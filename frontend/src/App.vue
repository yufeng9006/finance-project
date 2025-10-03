<script setup>
import { ref, onMounted } from 'vue'

// 响应式数据
const accounts = ref([])
const categories = ref([])
const transactions = ref([])
const budgets = ref([])

// 获取账户数据
const fetchAccounts = async () => {
  try {
    // 这里应该是实际的API调用
    // const response = await fetch('/api/accounts')
    // accounts.value = await response.json()
    accounts.value = [
      { id: 1, name: '现金', type: 'cash', balance: 1000.00, is_active: true },
      { id: 2, name: '储蓄卡', type: 'bank', balance: 5000.00, is_active: true },
      { id: 3, name: '信用卡', type: 'credit', balance: -2000.00, is_active: true }
    ]
  } catch (error) {
    console.error('获取账户数据失败:', error)
  }
}

// 获取分类数据
const fetchCategories = async () => {
  try {
    // 这里应该是实际的API调用
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
    // 这里应该是实际的API调用
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
    // 这里应该是实际的API调用
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

// 计算总览数据
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
  fetchAccounts()
  fetchCategories()
  fetchTransactions()
  fetchBudgets()
})
</script>

<template>
  <div id="app">
    <header>
      <h1>家庭财务管理系统</h1>
    </header>
    
    <main>
      <section class="section">
        <h2>财务总览</h2>
        <div class="summary-cards">
          <div class="summary-card">
            <h3>总收入</h3>
            <p class="amount income">¥{{ calculateSummary().totalIncome.toFixed(2) }}</p>
          </div>
          <div class="summary-card">
            <h3>总支出</h3>
            <p class="amount expense">¥{{ calculateSummary().totalExpense.toFixed(2) }}</p>
          </div>
          <div class="summary-card">
            <h3>账户余额</h3>
            <p class="amount balance">¥{{ calculateSummary().balance.toFixed(2) }}</p>
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
    </main>
    
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

header h1 {
  text-align: center;
  color: #2c3e50;
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

@media (prefers-color-scheme: dark) {
  #app {
    background-color: #1a1a1a;
  }
}
</style>