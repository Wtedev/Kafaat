<script setup>
import { useForm, Link } from '@inertiajs/vue3'

const form = useForm({
  name: '',
  email: '',
  phone_number: '',
  password: '',
})

const submit = () => {
  form.post(route('admin.employees.store'))
}
</script>

<template>
  <div class="p-6 max-w-xl space-y-4">
    <div class="flex items-center justify-between">
      <h1 class="text-xl font-semibold">إنشاء موظف</h1>
      <Link :href="route('admin.employees.index')" class="underline">رجوع</Link>
    </div>

    <form class="space-y-3" @submit.prevent="submit">
      <div>
        <label class="block text-sm mb-1">الاسم</label>
        <input v-model="form.name" class="w-full border rounded p-2" />
        <div v-if="form.errors.name" class="text-red-600 text-sm mt-1">{{ form.errors.name }}</div>
      </div>

      <div>
        <label class="block text-sm mb-1">الإيميل</label>
        <input v-model="form.email" type="email" class="w-full border rounded p-2" />
        <div v-if="form.errors.email" class="text-red-600 text-sm mt-1">{{ form.errors.email }}</div>
      </div>

      <div>
        <label class="block text-sm mb-1">رقم الجوال (اختياري)</label>
        <input v-model="form.phone_number" class="w-full border rounded p-2" />
        <div v-if="form.errors.phone_number" class="text-red-600 text-sm mt-1">
          {{ form.errors.phone_number }}
        </div>
      </div>

      <div>
        <label class="block text-sm mb-1">كلمة المرور</label>
        <input v-model="form.password" type="password" class="w-full border rounded p-2" />
        <div v-if="form.errors.password" class="text-red-600 text-sm mt-1">{{ form.errors.password }}</div>
      </div>

      <button
        type="submit"
        class="px-4 py-2 rounded bg-black text-white"
        :disabled="form.processing"
      >
        حفظ
      </button>
    </form>
  </div>
</template>
