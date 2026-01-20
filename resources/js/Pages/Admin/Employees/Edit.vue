<script setup>
import { useForm, Link } from '@inertiajs/vue3'

const props = defineProps({
  employee: Object,
})

const form = useForm({
  name: props.employee.name,
  email: props.employee.email,
  phone_number: props.employee.phone_number ?? '',
  password: '', // اختياري
})

const submit = () => {
  form.put(route('admin.employees.update', props.employee.id))
}
</script>

<template>
  <div class="p-6 max-w-xl space-y-4">
    <div class="flex items-center justify-between">
      <h1 class="text-xl font-semibold">تعديل موظف</h1>
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
        <label class="block text-sm mb-1">رقم الجوال</label>
        <input v-model="form.phone_number" class="w-full border rounded p-2" />
        <div v-if="form.errors.phone_number" class="text-red-600 text-sm mt-1">
          {{ form.errors.phone_number }}
        </div>
      </div>

      <div>
        <label class="block text-sm mb-1">كلمة مرور جديدة (اختياري)</label>
        <input v-model="form.password" type="password" class="w-full border rounded p-2" />
        <div v-if="form.errors.password" class="text-red-600 text-sm mt-1">{{ form.errors.password }}</div>
      </div>

      <button
        type="submit"
        class="px-4 py-2 rounded bg-black text-white"
        :disabled="form.processing"
      >
        تحديث
      </button>
    </form>
  </div>
</template>
