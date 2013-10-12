Asset
=====

资源(CSS, JS, 图片等素材文件)URL地址生成

案例
----

### 生成文件`jquery.js`的资源路径

```php
echo wei()->asset('jquery.js');

// 输出类似如下
'/assets/jquery.js';
```

### 通过配置版本号,解决浏览器缓存资源文件的问题

```php
// 在配置文件中设置资源版本号
wei(array(
    'asset' => array(
        'version' => '1'
    )
));

// 在视图中使用asset服务生成URL地址
echo wei()->asset('style.css');

// 输出的URL地址类似
`/assets/style.css?v=1`
```

调用方式
--------

### 选项

名称                | 类型    | 默认值    | 说明
--------------------|---------|-----------|------
dir                 | string  | assets    | 资源所在的目录
version             | string  | 无        | 自动附加到URL结尾的版本号码

### 方法

#### asset($file)
生成指定文件的资源URL地址