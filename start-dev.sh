#!/bin/bash

# 启动开发环境的脚本
# 包含前端 (npm run dev) 和后端 (php artisan serve) 服务

echo "正在启动开发环境..."

# 后端服务 (Laravel)
echo "正在启动后端服务 (PHP Laravel)..."
cd backend
php artisan serve > ../laravel.log 2>&1 &
LARAVEL_PID=$!
cd ..

# 前端服务 (Vite)
echo "正在启动前端服务 (Vite)..."
cd frontend
npm run dev > ../vite.log 2>&1 &
VITE_PID=$!
cd ..

echo "服务已启动:"
echo "  后端服务 PID: $LARAVEL_PID (日志: laravel.log)"
echo "  前端服务 PID: $VITE_PID (日志: vite.log)"
echo ""
echo "请等待几秒钟让服务完全启动，然后访问:"
echo "  前端: http://localhost:5173"
echo "  后端API: http://localhost:8000/api"

# 显示服务状态的函数
show_status() {
  if ps -p $LARAVEL_PID > /dev/null; then
    echo "后端服务: 运行中 (PID: $LARAVEL_PID)"
  else
    echo "后端服务: 已停止"
  fi
  
  if ps -p $VITE_PID > /dev/null; then
    echo "前端服务: 运行中 (PID: $VITE_PID)"
  else
    echo "前端服务: 已停止"
  fi
}

# 停止服务的函数
stop_services() {
  echo "正在停止服务..."
  kill $LARAVEL_PID 2>/dev/null
  kill $VITE_PID 2>/dev/null
  echo "服务已停止"
}

# 监听 Ctrl+C 信号以优雅地停止服务
trap stop_services EXIT

# 主循环 - 显示状态并等待退出
while true; do
  echo ""
  echo "按 Ctrl+C 停止服务"
  sleep 10
done