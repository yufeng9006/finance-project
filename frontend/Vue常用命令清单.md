# Vue 常用命令清单

## 项目初始化

### 创建新项目
```bash
npm create vue@latest
```

### 安装依赖
```bash
npm install
```

## 开发命令

### 启动开发服务器
```bash
npm run dev
```

### 构建生产版本
```bash
npm run build
```

### 预览生产构建
```bash
npm run preview
```

## 组件和路由

### 创建新组件
在 `src/components/` 目录下创建 `.vue` 文件

### 创建路由
在 `src/router/` 目录下配置路由

## 状态管理 (Pinia)

### 创建 Store
```bash
npm install pinia
```

然后在 `src/stores/` 目录下创建 store 文件

## 测试

### 单元测试
```bash
npm run test:unit
```

### 端到端测试
```bash
npm run test:e2e
```

## 代码质量

### 代码检查
```bash
npm run lint
```

### 修复代码格式
```bash
npm run lint:fix
```

## 环境配置

### 开发环境
```bash
npm run dev
```

### 生产环境构建
```bash
npm run build
```

### 自定义环境变量
创建 `.env` 文件:
- `.env` - 所有环境通用
- `.env.development` - 开发环境
- `.env.production` - 生产环境

环境变量必须以 `VITE_` 开头才能在客户端代码中使用。

## 构建配置

### 自定义 vite 配置
编辑 `vite.config.js` 文件

### 配置代理
在 `vite.config.js` 中配置 server.proxy 选项

## 调试

### Vue DevTools
安装浏览器扩展以方便调试 Vue 应用

### 浏览器调试
使用浏览器开发者工具进行调试