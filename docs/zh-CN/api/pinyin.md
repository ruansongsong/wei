Pinyin
======

将中文转换为拼音字母

案例
----

### 转换"微框架"为拼音字母

```php
// 输出`PHPweikuangjia`
echo wei()->pinyin('PHP微框架');
```

调用方式
--------

### 选项

*无*

### 方法

#### pinyin($word)

将中文转换为拼音字母

**返回:** `string` 拼音字母

**参数**

名称        | 类型         | 说明
------------|--------------|------
$word       | string       | 要转换的中文字符
