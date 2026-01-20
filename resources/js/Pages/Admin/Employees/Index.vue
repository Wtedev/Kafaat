<script setup>
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
  employees: Object,
})

const destroyEmployee = (id) => {
  if (!confirm('متأكد تبغى تحذف الموظف؟')) return
  router.delete(route('admin.employees.destroy', id))
}
</script>

<template>
  <div class="p-6 space-y-4">
    <div class="flex items-center justify-between">
      <h1 class="text-xl font-semibold">الموظفين</h1>
      <Link
        :href="route('admin.employees.create')"
        class="px-4 py-2 rounded bg-black text-white"
      >
        إنشاء موظف
      </Link>
    </div>

    <div class="bg-white rounded border">
      <table class="w-full text-sm">
        <thead class="text-left border-b">
          <tr>
            <th class="p-3">الاسم</th>
            <th class="p-3">الإيميل</th>
            <th class="p-3">الجوال</th>
            <th class="p-3 w-48">إجراءات</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="e in props.employees.data" :key="e.id" class="border-b">
            <td class="p-3">{{ e.name }}</td>
            <td class="p-3">{{ e.email }}</td>
            <td class="p-3">{{ e.phone_number ?? '-' }}</td>
            <td class="p-3 flex gap-2">
              <Link
                :href="route('admin.employees.edit', e.id)"
                class="px-3 py-1 rounded border"
              >
                تعديل
              </Link>
              <button
                type="button"
                class="px-3 py-1 rounded border border-red-400 text-red-600"
                @click="destroyEmployee(e.id)"
              >
                حذف
              </button>
            </td>
          </tr>
          <tr v-if="props.employees.data.length === 0">
            <td class="p-3" colspan="4">لا يوجد موظفين.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="flex gap-2 flex-wrap">
      <Link
        v-for="l in props.employees.links"
        :key="l.label"
        :href="l.url ?? ''"
        class="px-3 py-1 rounded border"
        :class="{ 'opacity-50 pointer-events-none': !l.url, 'bg-black text-white': l.active }"
        v-html="l.label"
      />
    </div>
  </div>
</template>
