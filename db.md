# 数据库说明

## 数据库名称

home_finance_system

## 数据库设置步骤

1. 确保 MySQL 服务正在运行:
   ```
   sudo service mysql start
   ```
   或在 macOS 上:
   ```
   brew services start mysql
   ```

2. 登录 MySQL:
   ```
   mysql -u root -p
   ```

3. 创建数据库:
   ```sql
   CREATE DATABASE home_finance_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

4. 创建用户并授权(可选):
   ```sql
   CREATE USER 'finance_user'@'localhost' IDENTIFIED BY 'finance_password';
   GRANT ALL PRIVILEGES ON home_finance_system.* TO 'finance_user'@'localhost';
   FLUSH PRIVILEGES;
   ```

## 数据库表结构

### financial_categories 表 - 财务分类表
存储收入和支出的分类信息

字段:
- id: 主键
- name: 分类名称
- description: 分类描述
- type: 类型 (income - 收入, expense - 支出)
- created_at: 创建时间
- updated_at: 更新时间

### accounts 表 - 账户表
存储不同类型的账户信息

字段:
- id: 主键
- name: 账户名称
- type: 账户类型 (如现金、银行账户、信用卡等)
- balance: 账户余额
- description: 账户描述
- is_active: 是否激活
- created_at: 创建时间
- updated_at: 更新时间

### transactions 表 - 交易记录表
存储所有的收入和支出交易记录

字段:
- id: 主键
- account_id: 关联账户ID
- category_id: 关联分类ID
- amount: 交易金额
- description: 交易描述
- transaction_date: 交易日期
- type: 交易类型 (income - 收入, expense - 支出)
- created_at: 创建时间
- updated_at: 更新时间

### budgets 表 - 预算表
存储预算信息

字段:
- id: 主键
- category_id: 关联分类ID
- amount: 预算金额
- start_date: 预算开始日期
- end_date: 预算结束日期
- description: 预算描述
- created_at: 创建时间
- updated_at: 更新时间