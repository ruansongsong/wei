<?php
/**
 * Widget Framework
 *
 * @copyright   Twin Huang
 * @license     http://opensource.org/licenses/mit-license.php MIT License
 */

namespace Widget;
use Widget\Db\Collection;

/**
 * A base database record class
 *
 * @author      Twin Huang <twinhuang@qq.com>
 */
class Record extends  AbstractWidget
{
    /**
     * The record table name
     *
     * @var string
     */
    protected $table;

    protected $fullTable;

    protected $primaryKey = 'id';

    /**
     * The record data
     *
     * @var array
     */
    protected $data = array();

    /**
     * The database widget
     *
     * @var Db
     */
    protected $db;

    /**
     * Return the record table name
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Set the record table name
     *
     * @param string $table
     * @return Record
     */
    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Returns a the record data
     *
     * @return array
     */
    public function toArray()
    {
        $data = array();
        foreach ($this->data as $field => $value) {
            if ($value instanceof Record || $value instanceof Collection) {
                $data[$field] = $value->toArray();
            } else {
                $data[$field] = $value;
            }
        }
        return $data;
    }

    /**
     * Import a PHP array in this record
     *
     * @param $data
     * @return Record
     */
    public function fromArray($data)
    {
        $this->data = $data + $this->data;

        return $this;
    }

    /**
     *
     *
     * @param $field
     * @return $this
     */
    public function clear($field)
    {
        if (isset($this->data[$field])) {
            unset($this->data[$field]);
        }

        return $this;
    }

    /**
     * Set record data
     *
     * @param $data
     * @return Record
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function save($data = array())
    {
        $data && $this->fromArray($data);

        return $this->db->insert($this->table, $this->data);
    }

    /**
     * Delete the current record
     *
     * @return int
     */
    public function delete()
    {
        return (bool)$this->db->delete($this->table, array($this->primaryKey => $this->data[$this->primaryKey]));
    }

    public function __get($name)
    {
        $db = $this->db;
        $fieldName = $this->db->camelCaseToUnderscore($name);
        $relations = $this->db->getTableRelation($this->table);

        if (isset($this->data[$fieldName])) {
            return $this->data[$fieldName];
        } elseif (isset($relations[$name])) {
            return $this->data[$fieldName] = $this->db->find($relations[$name]['table'], array(
                'id' => $this->data[$relations[$name]['column']]
            ));
            // has one
        } elseif (isset($this->data[$name . '_id'])) {
            return $this->data[$fieldName] = $this->db->find($db->getTableByField($name), array(
                'id' => $this->data[$name . '_id']
            ));
            // one to many
        } elseif (substr($name, -1) == 's') {
            $table = substr($name, 0, -1);
            return $this->data[$fieldName] = $this->db->findAll($db->getTableByField($table), array(
                $db->getSingular($this->table) . '_id' => $this->data['id']
            ));
            // belong to
        } else {
            return $this->data[$fieldName] = $this->db->find($db->getTableByField($name), array(
                $db->getSingular($this->table) . '_id' => $this->data['id']
            ));
        }
    }

    /**
     * A helper method to find a record
     *
     * @param $id
     * @return Record
     */
    public function find($id)
    {
        return $this->db->find($this->getTable(), $id);
    }
}