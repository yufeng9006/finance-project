# 数据库说明文档

## 数据库基本信息

- 数据库名称: home_finance_system
- 字符集: utf8mb4
- 排序规则: utf8mb4_unicode_ci

## 数据表结构

### users 表
用户表，存储系统用户信息

字段:
- id: bigint unsigned, 主键, 自增
- name: varchar(255), 用户名
- email: varchar(255), 邮箱, 唯一
- email_verified_at: timestamp, 邮箱验证时间
- password: varchar(255), 密码
- remember_token: varchar(100), 记住我令牌
- created_at: timestamp, 创建时间
- updated_at: timestamp, 更新时间

### password_reset_tokens 表
密码重置令牌表

字段:
- email: varchar(255), 邮箱, 主键
- token: varchar(255), 令牌
- created_at: timestamp, 创建时间

### failed_jobs 表
失败任务表

字段:
- id: bigint unsigned, 主键, 自增
- uuid: varchar(255), UUID, 唯一
- connection: text, 连接信息
- queue: text, 队列名称
- payload: longtext, 任务数据
- exception: longtext, 异常信息
- failed_at: timestamp, 失败时间, 默认当前时间

### personal_access_tokens 表
个人访问令牌表

字段:
- id: bigint unsigned, 主键, 自增
- tokenable_type: varchar(255), 可令牌化类型
- tokenable_id: bigint unsigned, 可令牌化ID
- name: varchar(255), 令牌名称
- token: varchar(64), 令牌, 唯一
- abilities: text, 权限
- last_used_at: timestamp, 最后使用时间
- expires_at: timestamp, 过期时间
- created_at: timestamp, 创建时间
- updated_at: timestamp, 更新时间

### financial_categories 表
财务分类表

字段:
- id: bigint unsigned, 主键, 自增
- name: varchar(255), 分类名称
- type: enum('income','expense'), 分类类型(收入/支出)
- icon: varchar(255), 图标
- color: varchar(255), 颜色
- parent_id: bigint unsigned, 父级分类ID
- is_active: tinyint(1), 是否启用, 默认1
- created_at: timestamp, 创建时间
- updated_at: timestamp, 更新时间

### accounts 表
账户表

字段:
- id: bigint unsigned, 主键, 自增
- name: varchar(255), 账户名称
- type: varchar(255), 账户类型
- balance: decimal(15,2), 余额, 默认0.00
- description: text, 描述
- is_active: tinyint(1), 是否启用, 默认1
- created_at: timestamp, 创建时间
- updated_at: timestamp, 更新时间

### transactions 表
交易记录表

字段:
- id: bigint unsigned, 主键, 自增
- account_id: bigint unsigned, 账户ID, 外键(accounts.id)
- category_id: bigint unsigned, 分类ID, 外键(financial_categories.id)
- type: enum('income','expense'), 交易类型(收入/支出)
- amount: decimal(15,2), 金额
- description: text, 描述
- occurred_at: timestamp, 交易时间
- created_at: timestamp, 创建时间
- updated_at: timestamp, 更新时间

### budgets 表
预算表

字段:
- id: bigint unsigned, 主键, 自增
- category_id: bigint unsigned, 分类ID, 外键(financial_categories.id)
- amount: decimal(15,2), 预算金额
- period: enum('daily','weekly','monthly','yearly'), 预算周期
- start_date: date, 开始日期
- end_date: date, 结束日期
- is_active: tinyint(1), 是否启用, 默认1
- created_at: timestamp, 创建时间
- updated_at: timestamp, 更新时间