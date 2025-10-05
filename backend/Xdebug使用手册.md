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
xdebug.start_with_request=trigger
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
                "/var/www/html": "${workspaceFolder}/backend"
            }
        }
    ]
}
```

### 首次使用步骤

1. 打开 VSCode 并加载整个项目（确保打开的是 `finance-project-2` 根目录）
2. 打开 `.vscode/launch.json` 文件确认配置正确
3. 点击左侧"运行和调试"图标（或按 Ctrl+Shift+D / Cmd+Shift+D）
4. 从配置下拉菜单中选择合适的调试配置：
   - "Listen for Xdebug (API Debug)" - 用于调试 API 请求
   - "Listen for Xdebug with Exception Breakpoints" - 用于调试异常
5. 点击绿色的"开始调试"按钮（或按 F5）启动调试监听器
6. 在代码中设置断点（在行号左侧点击）
7. 发起带有 `XDEBUG_TRIGGER` 的 API 请求

### 开始调试

1. 确保 VSCode 调试监听器已启动（状态栏显示红色条目）
2. 设置断点（在行号左侧点击）
3. 在发起API请求时添加XDEBUG_TRIGGER参数或设置请求头
4. 在浏览器或前端应用中访问你的应用程序

## 前后端分离架构调试

在前后端分离架构中，由于请求通常不是直接通过浏览器发起，需要特殊处理才能触发Xdebug调试。

### 方法一：使用XDEBUG_TRIGGER参数

在API请求中添加`XDEBUG_TRIGGER`参数：
```
GET http://localhost:8000/api/accounts?XDEBUG_TRIGGER=1
```

### 方法二：使用请求头

在API请求中添加`XDEBUG_TRIGGER`请求头：
```
XDEBUG_TRIGGER: 1
```

### 方法三：使用专门的调试配置

使用我们提供的"Listen for Xdebug (API Debug)"配置，它会自动设置环境变量：
```json
{
    "name": "Listen for Xdebug (API Debug)",
    "type": "php",
    "request": "launch",
    "port": 9003,
    "pathMappings": {
        "/var/www/html": "${workspaceFolder}/backend"
    },
    "env": {
        "XDEBUG_TRIGGER": "1"
    }
}
```

## 错误监控优化

### 异常断点配置

新增了异常断点配置，可以在发生异常时自动中断执行：

```json
{
    "name": "Listen for Xdebug with Exception Breakpoints",
    "type": "php",
    "request": "launch",
    "port": 9003,
    "pathMappings": {
        "/var/www/html": "${workspaceFolder}/backend"
    },
    "log": true,
    "breakpoint_exception": [
        "Exception",
        "Error",
        "Throwable"
    ]
}
```

### 增强的错误显示

Xdebug 可以增强错误显示，提供更详细的错误信息：

```ini
; 显示错误跟踪
xdebug.show_error_trace=1

; 显示异常跟踪 (设为0避免在控制台产生过多输出)
xdebug.show_exception_trace=0

; 收集参数信息
xdebug.collect_params=4

; 显示局部变量
xdebug.show_local_vars=1
```

### 日志记录

启用详细的日志记录有助于诊断调试问题：

```ini
; 启用日志记录
xdebug.log=/tmp/xdebug.log
xdebug.log_level=7
```

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

1. 检查路径映射是否正确（非常重要！）
2. 确认文件路径是否匹配
3. 验证 Xdebug 配置是否正确
4. 检查是否使用了正确的触发方式（在前后端分离架构中尤其重要）
5. 确保 VSCode 调试监听器已启动
6. 检查是否选择了正确的调试配置

### 路径映射问题

在本项目中，正确路径映射应该为：
```
"/var/www/html": "${workspaceFolder}/backend"
```

这是因为：
- `/var/www/html` 是 Docker 容器中的项目路径
- `${workspaceFolder}/backend` 是本地文件系统中的实际后端代码路径

### 前后端分离调试问题

在前后端分离架构中，断点无法触发的常见原因：

1. Xdebug配置为`start_with_request=yes`模式，但前后端分离请求缺少触发条件
2. 没有正确设置`XDEBUG_TRIGGER`参数或请求头
3. 使用了错误的调试配置
4. VSCode调试监听器未启动
5. 项目未正确打开在VSCode中（需要打开根目录而不是backend子目录）

解决方案：
1. 将Xdebug配置为`xdebug.start_with_request=trigger`模式
2. 在API请求中添加`XDEBUG_TRIGGER=1`参数或请求头
3. 使用专门的API调试配置
4. 确保VSCode调试监听器已启动
5. 确保在VSCode中打开的是项目根目录（finance-project-2）

## 高级调试技巧

### 监控特定异常

使用异常断点配置，可以在特定异常发生时自动中断执行，便于调试难以重现的问题。

### 性能分析

通过启用性能分析模式，可以分析代码执行的性能瓶颈，找出耗时较长的函数。

### 远程调试

Xdebug 支持远程调试，可以调试在服务器上运行的 PHP 应用程序。

## 参考资料

- [Xdebug 官方文档](https://xdebug.org/docs/)
- [VSCode PHP Debug 扩展](https://marketplace.visualstudio.com/items?itemName=felixfbecker.php-debug)