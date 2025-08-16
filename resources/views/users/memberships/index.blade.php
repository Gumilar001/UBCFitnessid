<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Manajemen User</h2>
    </x-slot>
<div class="p-6">
    <h1 class="text-xl font-bold mb-4">My Memberships</h1>
    <table class="table-auto w-full border">
        <thead>
            <tr>
                <th class="border px-4 py-2">Membership Name</th>
                <th class="border px-4 py-2">Start Date</th>
                <th class="border px-4 py-2">End Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($memberships as $membership)
                <tr class="text-center">
                    <td class="border px-4 py-2">{{ $membership->membership->name }}</td>
                    <td class="border px-4 py-2">{{ $membership->start_date }}</td>
                    <td class="border px-4 py-2">{{ $membership->end_date }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="border px-4 py-2 text-center">No memberships found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</x-app-layout>
