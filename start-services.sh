#!/bin/bash

# 简单的开发环境启动脚本
# 分别启动前端和后端服务

echo "Finance Project - 开发环境启动脚本"
echo "================================"

echo "1. 启动后端服务 (Laravel)"
echo "   进入 backend 目录并运行 'php artisan serve'"
echo "   默认地址: http://localhost:8000"
echo ""
echo "2. 启动前端服务 (Vite)"
echo "   进入 frontend 目录并运行 'npm run dev'"
echo "   默认地址: http://localhost:5173"
echo ""
echo "使用说明:"
echo "---------"
echo "打开一个新的终端窗口，执行以下命令启动后端服务:"
echo "  cd backend && php artisan serve"
echo ""
echo "再打开一个新的终端窗口，执行以下命令启动前端服务:"
echo "  cd frontend && npm run dev"
echo ""
echo "服务启动后，打开浏览器访问 http://localhost:5173"