<template>
  <div class="accounts-container">
    <h2>账户管理</h2>
    
    <!-- 添加账户按钮 -->
    <button @click="showAddForm = true" class="btn btn-primary mb-3">添加账户</button>
    
    <!-- 添加账户表单 -->
    <div v-if="showAddForm" class="card mb-4">
      <div class="card-body">
        <h5 class="card-title">添加新账户</h5>
        <form @submit.prevent="addAccount">
          <div class="mb-3">
            <label for="accountName" class="form-label">账户名称</label>
            <input type="text" class="form-control" id="accountName" v-model="newAccount.name" required>
          </div>
          <div class="mb-3">
            <label for="accountType" class="form-label">账户类型</label>
            <select class="form-select" id="accountType" v-model="newAccount.type" required>
              <option value="cash">现金</option>
              <option value="bank">银行</option>
              <option value="credit">信用卡</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="accountBalance" class="form-label">初始余额</label>
            <input type="number" class="form-control" id="accountBalance" v-model="newAccount.balance" step="0.01" required>
          </div>
          <div class="mb-3">
            <label for="accountDescription" class="form-label">描述</label>
            <textarea class="form-control" id="accountDescription" v-model="newAccount.description"></textarea>
          </div>
          <button type="submit" class="btn btn-success">保存</button>
          <button type="button" class="btn btn-secondary ms-2" @click="cancelAdd">取消</button>
        </form>
      </div>
    </div>
    
    <!-- 账户列表 -->
    <div class="row">
      <div v-for="account in accounts" :key="account.id" class="col-md-6 col-lg-4 mb-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ account.name }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{ getAccountTypeName(account.type) }}</h6>
            <p class="card-text">
              余额: <span :class="account.balance >= 0 ? 'text-success' : 'text-danger'">
                ¥{{ account.balance.toFixed(2) }}
              </span>
            </p>
            <p v-if="account.description" class="card-text">{{ account.description }}</p>
            
            <div class="d-flex justify-content-between">
              <button @click="editAccount(account)" class="btn btn-sm btn-outline-primary">编辑</button>
              <button @click="deleteAccount(account.id)" class="btn btn-sm btn-outline-danger">删除</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- 编辑账户模态框 -->
    <div v-if="editingAccount" class="modal show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">编辑账户</h5>
            <button type="button" class="btn-close" @click="cancelEdit"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updateAccount">
              <div class="mb-3">
                <label for="editAccountName" class="form-label">账户名称</label>
                <input type="text" class="form-control" id="editAccountName" v-model="editingAccount.name" required>
              </div>
              <div class="mb-3">
                <label for="editAccountType" class="form-label">账户类型</label>
                <select class="form-select" id="editAccountType" v-model="editingAccount.type" required>
                  <option value="cash">现金</option>
                  <option value="bank">银行</option>
                  <option value="credit">信用卡</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="editAccountBalance" class="form-label">余额</label>
                <input type="number" class="form-control" id="editAccountBalance" v-model="editingAccount.balance" step="0.01" required>
              </div>
              <div class="mb-3">
                <label for="editAccountDescription" class="form-label">描述</label>
                <textarea class="form-control" id="editAccountDescription" v-model="editingAccount.description"></textarea>
              </div>
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="editAccountActive" v-model="editingAccount.is_active">
                <label class="form-check-label" for="editAccountActive">
                  激活状态
                </label>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="cancelEdit">取消</button>
            <button type="button" class="btn btn-primary" @click="updateAccount">保存</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

// API基础URL
const API_BASE_URL = 'http://127.0.0.1:8000/api' // 修改为正确的后端API地址

// 从localStorage获取token
const token = localStorage.getItem('token')

// 数据定义
const accounts = ref([])
const showAddForm = ref(false)
const newAccount = ref({
  name: '',
  type: 'cash',
  balance: 0,
  description: ''
})
const editingAccount = ref(null)

// 获取账户类型名称
const getAccountTypeName = (type) => {
  const types = {
    'cash': '现金',
    'bank': '银行',
    'credit': '信用卡'
  }
  return types[type] || type
}

// 获取账户列表
const fetchAccounts = async () => {
  if (!token) return
  
  try {
    const response = await fetch(`${API_BASE_URL}/accounts`, {
      headers: {
        'Authorization': `Bearer ${token}`,
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

// 添加账户
const addAccount = async () => {
  if (!token) return
  
  try {
    const response = await fetch(`${API_BASE_URL}/accounts`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      },
      body: JSON.stringify(newAccount.value)
    })
    
    const result = await response.json()
    if (result.code === 201) {
      showAddForm.value = false
      resetNewAccount()
      await fetchAccounts()
    } else {
      console.error('添加账户失败:', result.message)
    }
  } catch (error) {
    console.error('添加账户失败:', error)
  }
}

// 取消添加
const cancelAdd = () => {
  showAddForm.value = false
  resetNewAccount()
}

// 重置新账户表单
const resetNewAccount = () => {
  newAccount.value = {
    name: '',
    type: 'cash',
    balance: 0,
    description: ''
  }
}

// 编辑账户
const editAccount = (account) => {
  editingAccount.value = {
    id: account.id,
    name: account.name,
    type: account.type,
    balance: account.balance,
    description: account.description,
    is_active: account.is_active
  }
}

// 更新账户
const updateAccount = async () => {
  if (!editingAccount.value || !token) return
  
  try {
    const response = await fetch(`${API_BASE_URL}/accounts/${editingAccount.value.id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      },
      body: JSON.stringify(editingAccount.value)
    })
    
    const result = await response.json()
    if (result.code === 200) {
      editingAccount.value = null
      await fetchAccounts()
    } else {
      console.error('更新账户失败:', result.message)
    }
  } catch (error) {
    console.error('更新账户失败:', error)
  }
}

// 取消编辑
const cancelEdit = () => {
  editingAccount.value = null
}

// 删除账户
const deleteAccount = async (id) => {
  if (!token) return
  
  if (!confirm('确定要删除这个账户吗？')) return
  
  try {
    const response = await fetch(`${API_BASE_URL}/accounts/${id}`, {
      method: 'DELETE',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    })
    
    const result = await response.json()
    if (result.code === 200) {
      await fetchAccounts()
    } else {
      console.error('删除账户失败:', result.message)
    }
  } catch (error) {
    console.error('删除账户失败:', error)
  }
}

// 组件挂载时获取数据
onMounted(() => {
  fetchAccounts()
})
</script>

<style scoped>
.accounts-container {
  padding: 20px;
}

.btn {
  border-radius: 4px;
}

.card {
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.modal {
  z-index: 1050;
}

.mb-3 {
  margin-bottom: 1rem;
}

.mb-4 {
  margin-bottom: 1.5rem;
}

.d-block {
  display: block;
}

.text-success {
  color: #28a745;
}

.text-danger {
  color: #dc3545;
}

.form-label {
  font-weight: 500;
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
}

.btn-success {
  background-color: #28a745;
  border-color: #28a745;
}

.btn-secondary {
  background-color: #6c757d;
  border-color: #6c757d;
}
</style>