<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEmployeeRequest;
use App\Http\Requests\Admin\UpdateEmployeeRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::query()
            ->whereHas('roles', fn ($q) => $q->where('name', 'employee'))
            ->select(['id', 'name', 'email', 'phone_number', 'created_at'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Employees/Index', [
            'employees' => $employees,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Employees/Create');
    }

    public function store(StoreEmployeeRequest $request)
    {
        $data = $request->validated();

        $employee = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        // شرطك: الإنشاء من الأدمن = employee فقط
        $employee->syncRoles(['employee']);

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'تم إنشاء الموظف بنجاح.');
    }

    public function edit(User $employee)
    {
        abort_unless($employee->hasRole('employee'), 404);

        return Inertia::render('Admin/Employees/Edit', [
            'employee' => [
                'id' => $employee->id,
                'name' => $employee->name,
                'email' => $employee->email,
                'phone_number' => $employee->phone_number,
            ],
        ]);
    }

    public function update(UpdateEmployeeRequest $request, User $employee)
    {
        abort_unless($employee->hasRole('employee'), 404);

        $data = $request->validated();

        $employee->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'] ?? null,
        ]);

        if (!empty($data['password'])) {
            $employee->update([
                'password' => Hash::make($data['password']),
            ]);
        }

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'تم تحديث بيانات الموظف.');
    }

    public function destroy(User $employee)
    {
        abort_unless($employee->hasRole('employee'), 404);

        $employee->delete();

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'تم حذف الموظف.');
    }
}
