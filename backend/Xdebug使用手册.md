# Xdebug 使用手册

## 安装与配置

Xdebug 已经安装并配置好，以下是使用说明：

### 配置文件位置

Xdebug 的配置通常位于 PHP 配置文件中，如：
- `/etc/php/8.1/apache2/conf.d/20-xdebug.ini`
- `/etc/php/8.1/cli/conf.d/20-xdebug.ini`

### 基本配置项

```ini
zend_extension=xdebug.so
xdebug.mode=debug
xdebug.start_with_request=yes
xdebug.client_host=127.0.0.1
xdebug.client_port=9003
```

## 在 VSCode 中使用 Xdebug

### 配置 launch.json

VSCode 中的 Xdebug 配置文件位于 `.vscode/launch.json`：

```json
{
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for Xdebug",
            "type": "php",
            "request": "launch",
            "port": 9003,
            "pathMappings": {
                "/var/www/html": "${workspaceFolder}"
            }
        }
    ]
}
```

### 开始调试

1. 打开 VSCode 并加载项目
2. 设置断点（在行号左侧点击）
3. 按 F5 或点击"运行和调试"面板中的绿色播放按钮
4. 在浏览器中访问你的应用程序

## 常用命令

### 在代码中添加断点

```php
<?php
xdebug_break(); // 强制中断点
?>
```

### 查看变量信息

```php
<?php
$variable = ['a', 'b', 'c'];
xdebug_var_dump($variable); // 详细输出变量信息
?>
```

### 性能分析

启用性能分析模式：
```ini
xdebug.mode=profile
xdebug.start_with_request=yes
```

查看性能分析结果可以使用工具如：
- WebGrind
- KCacheGrind
- QCacheGrind

## 常见问题解决

### 无法连接到 Xdebug

1. 检查防火墙设置
2. 确认端口是否正确（默认为 9003）
3. 检查 Xdebug 是否已正确加载：
   ```bash
   php -v
   ```
   
### 断点不触发

1. 检查路径映射是否正确
2. 确认文件路径是否匹配
3. 验证 Xdebug 配置是否正确

## 参考资料

- [Xdebug 官方文档](https://xdebug.org/docs/)
- [VSCode PHP Debug 扩展](https://marketplace.visualstudio.com/items?itemName=felixfbecker.php-debug)