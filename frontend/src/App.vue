<script setup>
import { ref, onMounted, reactive } from 'vue'
import Accounts from './Accounts.vue'

// API基础URL
const API_BASE_URL = 'http://127.0.0.1:8000/api' // 修改为正确的后端API地址

// 响应式数据
const accounts = ref([])
const categories = ref([])
const transactions = ref([])
const budgets = ref([])
const summary = ref({
  total_income: 0,
  total_expense: 0,
  balance: 0
})
const activeTab = ref('dashboard')

// 用户认证数据
const user = ref(null)
const token = ref(null)
const loginForm = reactive({
  email: '',
  password: ''
})
const registerForm = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
})

// 获取账户数据
const fetchAccounts = async () => {
  if (!token.value) return
  
  try {
    const response = await fetch(`${API_BASE_URL}/accounts`, {
      headers: {
        'Authorization': `Bearer ${token.value}`,
        'Accept': 'application/json'
      }
    })
    const result = await response.json()
    if (result.code === 200) {
      accounts.value = result.data
    } else {
      console.error('获取账户数据失败:', result.message)
    }
  } catch (error) {
    console.error('获取账户数据失败:', error)
  }
}

// 获取分类数据
const fetchCategories = async () => {
  try {
    // 实际项目中应该使用真实的API调用
    // const response = await fetch('/api/categories')
    // categories.value = await response.json()
    categories.value = [
      { id: 1, name: '工资', type: 'income', description: '工资收入' },
      { id: 2, name: '餐饮', type: 'expense', description: '餐饮支出' },
      { id: 3, name: '交通', type: 'expense', description: '交通费用' }
    ]
  } catch (error) {
    console.error('获取分类数据失败:', error)
  }
}

// 获取交易数据
const fetchTransactions = async () => {
  try {
    // 实际项目中应该使用真实的API调用
    // const response = await fetch('/api/transactions')
    // transactions.value = await response.json()
    transactions.value = [
      { id: 1, account_id: 1, category_id: 1, amount: 10000.00, description: '工资', transaction_date: '2025-10-01', type: 'income' },
      { id: 2, account_id: 1, category_id: 2, amount: 50.00, description: '午餐', transaction_date: '2025-10-02', type: 'expense' },
      { id: 3, account_id: 1, category_id: 3, amount: 20.00, description: '地铁', transaction_date: '2025-10-02', type: 'expense' }
    ]
  } catch (error) {
    console.error('获取交易数据失败:', error)
  }
}

// 获取预算数据
const fetchBudgets = async () => {
  try {
    // 实际项目中应该使用真实的API调用
    // const response = await fetch('/api/budgets')
    // budgets.value = await response.json()
    budgets.value = [
      { id: 1, category_id: 2, amount: 1000.00, start_date: '2025-10-01', end_date: '2025-10-31', description: '餐饮预算' },
      { id: 2, category_id: 3, amount: 500.00, start_date: '2025-10-01', end_date: '2025-10-31', description: '交通预算' }
    ]
  } catch (error) {
    console.error('获取预算数据失败:', error)
  }
}

// 获取统计摘要数据
const fetchSummary = async () => {
  try {
    // 实际项目中应该使用真实的API调用
    // const response = await fetch('/api/dashboard/summary')
    // summary.value = await response.json()
    summary.value = {
      total_income: 10000.00,
      total_expense: 70.00,
      balance: 9930.00
    }
  } catch (error) {
    console.error('获取统计摘要失败:', error)
  }
}

// 用户登录
const login = async () => {
  try {
    const response = await fetch(`${API_BASE_URL}/login`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(loginForm)
    })
    
    const result = await response.json()
    if (result.token) {
      token.value = result.token
      user.value = result.user
      // 保存到localStorage
      localStorage.setItem('token', token.value)
      localStorage.setItem('user', JSON.stringify(result.user))
    } else {
      console.error('登录失败:', result.message)
    }
  } catch (error) {
    console.error('登录失败:', error)
  }
}

// 用户注册
const register = async () => {
  try {
    const response = await fetch(`${API_BASE_URL}/register`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(registerForm)
    })
    
    const result = await response.json()
    if (result.token) {
      token.value = result.token
      user.value = result.user
      // 保存到localStorage
      localStorage.setItem('token', token.value)
      localStorage.setItem('user', JSON.stringify(result.user))
    } else {
      console.error('注册失败:', result.message)
    }
  } catch (error) {
    console.error('注册失败:', error)
  }
}

// 用户登出
const logout = () => {
  token.value = null
  user.value = null
  localStorage.removeItem('token')
  localStorage.removeItem('user')
}

// 检查本地存储的认证信息
const checkAuth = () => {
  const savedToken = localStorage.getItem('token')
  const savedUser = localStorage.getItem('user')
  
  if (savedToken && savedUser) {
    token.value = savedToken
    user.value = JSON.parse(savedUser)
  }
}

// 计算总览数据（用于演示）
const calculateSummary = () => {
  const totalIncome = transactions.value
    .filter(t => t.type === 'income')
    .reduce((sum, t) => sum + t.amount, 0)
    
  const totalExpense = transactions.value
    .filter(t => t.type === 'expense')
    .reduce((sum, t) => sum + t.amount, 0)
    
  const balance = totalIncome - totalExpense
  
  return { totalIncome, totalExpense, balance }
}

// 组件挂载时获取数据
onMounted(() => {
  checkAuth()
  if (token.value) {
    fetchAccounts()
    fetchCategories()
    fetchTransactions()
    fetchBudgets()
    fetchSummary()
  }
})
</script>

<template>
  <div id="app">
    <!-- 登录/注册表单 -->
    <div v-if="!token" class="auth-container">
      <div class="auth-form">
        <ul class="nav nav-tabs" id="authTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">登录</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">注册</button>
          </li>
        </ul>
        <div class="tab-content" id="authTabContent">
          <!-- 登录表单 -->
          <div class="tab-pane fade show active" id="login" role="tabpanel">
            <form @submit.prevent="login" class="p-4">
              <div class="mb-3">
                <label for="loginEmail" class="form-label">邮箱</label>
                <input type="email" class="form-control" id="loginEmail" v-model="loginForm.email" required>
              </div>
              <div class="mb-3">
                <label for="loginPassword" class="form-label">密码</label>
                <input type="password" class="form-control" id="loginPassword" v-model="loginForm.password" required>
              </div>
              <button type="submit" class="btn btn-primary">登录</button>
            </form>
          </div>
          
          <!-- 注册表单 -->
          <div class="tab-pane fade" id="register" role="tabpanel">
            <form @submit.prevent="register" class="p-4">
              <div class="mb-3">
                <label for="registerName" class="form-label">姓名</label>
                <input type="text" class="form-control" id="registerName" v-model="registerForm.name" required>
              </div>
              <div class="mb-3">
                <label for="registerEmail" class="form-label">邮箱</label>
                <input type="email" class="form-control" id="registerEmail" v-model="registerForm.email" required>
              </div>
              <div class="mb-3">
                <label for="registerPassword" class="form-label">密码</label>
                <input type="password" class="form-control" id="registerPassword" v-model="registerForm.password" required>
              </div>
              <div class="mb-3">
                <label for="registerPasswordConfirmation" class="form-label">确认密码</label>
                <input type="password" class="form-control" id="registerPasswordConfirmation" v-model="registerForm.password_confirmation" required>
              </div>
              <button type="submit" class="btn btn-success">注册</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- 已登录用户界面 -->
    <div v-else>
      <header>
        <h1>家庭财务管理系统</h1>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <p>欢迎, {{ user.name }}!</p>
          <button @click="logout" class="btn btn-outline-secondary">登出</button>
        </div>
        
        <!-- 导航栏 -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
          <div class="container-fluid">
            <div class="navbar-nav">
              <button 
                class="nav-link btn btn-link" 
                :class="{ 'active': activeTab === 'dashboard' }"
                @click="activeTab = 'dashboard'"
              >
                仪表盘
              </button>
              <button 
                class="nav-link btn btn-link" 
                :class="{ 'active': activeTab === 'accounts' }"
                @click="activeTab = 'accounts'"
              >
                账户管理
              </button>
            </div>
          </div>
        </nav>
      </header>
      
      <main>
        <!-- 仪表盘视图 -->
        <div v-if="activeTab === 'dashboard'">
          <section class="section">
            <h2>财务总览</h2>
            <div class="summary-cards">
              <div class="summary-card">
                <h3>总收入</h3>
                <p class="amount income">¥{{ summary.total_income.toFixed(2) }}</p>
              </div>
              <div class="summary-card">
                <h3>总支出</h3>
                <p class="amount expense">¥{{ summary.total_expense.toFixed(2) }}</p>
              </div>
              <div class="summary-card">
                <h3>账户余额</h3>
                <p class="amount balance">¥{{ summary.balance.toFixed(2) }}</p>
              </div>
            </div>
          </section>
          
          <section class="section">
            <h2>账户</h2>
            <div class="summary-cards">
              <div v-for="account in accounts" :key="account.id" class="summary-card">
                <h3>{{ account.name }}</h3>
                <p class="amount" :class="account.balance >= 0 ? 'income' : 'expense'">
                  ¥{{ account.balance.toFixed(2) }}
                </p>
                <p>{{ account.type }}</p>
              </div>
            </div>
          </section>
          
          <section class="section">
            <h2>最近交易</h2>
            <ul class="transaction-list">
              <li v-for="transaction in transactions" :key="transaction.id" class="transaction-item">
                <span class="transaction-description">{{ transaction.description }}</span>
                <span class="transaction-amount" :class="transaction.type">
                  {{ transaction.type === 'income' ? '+' : '-' }}¥{{ transaction.amount.toFixed(2) }}
                </span>
              </li>
            </ul>
          </section>
        </div>
        
        <!-- 账户管理视图 -->
        <div v-if="activeTab === 'accounts'">
          <Accounts />
        </div>
      </main>
    </div>
    
    <footer>
      <p>&copy; 2025 家庭财务管理系统</p>
    </footer>
  </div>
</template>

<style scoped>
#app {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

.auth-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 80vh;
}

.auth-form {
  width: 100%;
  max-width: 400px;
  border: 1px solid #dee2e6;
  border-radius: 8px;
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

header h1 {
  text-align: center;
  color: #2c3e50;
}

.navbar {
  border-radius: 8px;
}

.nav-link.btn-link {
  color: #6c757d;
  text-decoration: none;
}

.nav-link.btn-link:hover,
.nav-link.btn-link.active {
  color: #007bff;
  font-weight: 500;
}

.section {
  margin-bottom: 2rem;
}

.summary-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1rem;
  margin-top: 1rem;
}

.summary-card {
  background: #f8f9fa;
  border-radius: 8px;
  padding: 1.5rem;
  text-align: center;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.summary-card h3 {
  margin: 0 0 0.5rem 0;
  color: #6c757d;
  font-size: 1rem;
}

.amount {
  font-size: 1.5rem;
  font-weight: bold;
  margin: 0.5rem 0;
}

.income {
  color: #28a745;
}

.expense {
  color: #dc3545;
}

.balance {
  color: #007bff;
}

.transaction-list {
  list-style: none;
  padding: 0;
}

.transaction-item {
  display: flex;
  justify-content: space-between;
  padding: 0.75rem 1rem;
  border-bottom: 1px solid #eee;
}

.transaction-item:last-child {
  border-bottom: none;
}

.transaction-description {
  font-weight: 500;
}

.transaction-amount {
  font-weight: bold;
}

footer {
  text-align: center;
  margin-top: 2rem;
  padding-top: 1rem;
  border-top: 1px solid #eee;
  color: #666;
}

@media (prefers-color-scheme: light) {
  #app {
    background-color: #ffffff;
  }
}
</style>