@extends('layouts.app')

@section('title', 'Services')
@section('header_title', 'Services')

@section('content')
    <div class="flex justify-end mb-6">
        <button onclick="openModal()"
            class="bg-[#3A3E45] hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center shadow-sm">
            <i class="fa-solid fa-plus mr-2"></i> Add Data
        </button>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-visible relative">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-100 text-gray-500 text-sm">
                    <th class="py-4 px-6 font-medium">Service Name</th>
                    <th class="py-4 px-6 font-medium">Price</th>
                    <th class="py-4 px-6 font-medium">Status</th>
                    <th class="py-4 px-6 font-medium text-center">Action</th>
                </tr>
            </thead>

            <tbody id="service-table-body" class="text-sm text-gray-700">
                <tr>
                    <td colspan="4" class="text-center py-8 text-gray-400">
                        Loading data...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- ADD MODAL -->
    <div id="addModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">

                <form id="addServiceForm">

                    <div class="bg-white px-8 pt-8 pb-6">

                        <h3 class="text-2xl font-bold text-gray-900 text-center mb-6">
                            Add Services
                        </h3>

                        <div class="space-y-5">

                            <div>
                                <label class="block text-sm font-bold text-gray-800 mb-2">
                                    Service Name
                                </label>

                                <input type="text" name="name" required placeholder="Enter service name"
                                    class="block w-full border border-gray-200 rounded-lg py-3 px-4 focus:outline-none focus:ring-1 focus:ring-gray-800 text-gray-600 bg-gray-50/50">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-800 mb-2">
                                    Price
                                </label>

                                <input type="number" name="price" required min="0" placeholder="Enter your price"
                                    class="block w-full border border-gray-200 rounded-lg py-3 px-4 focus:outline-none focus:ring-1 focus:ring-gray-800 text-gray-600 bg-gray-50/50">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-800 mb-2">
                                    Description
                                </label>

                                <textarea name="description" rows="3" placeholder="Enter your description"
                                    class="block w-full border border-gray-200 rounded-lg py-3 px-4 focus:outline-none focus:ring-1 focus:ring-gray-800 text-gray-600 bg-gray-50/50"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-800 mb-2">
                                    Status
                                </label>

                                <select name="status" required
                                    class="block w-full border border-gray-200 rounded-lg py-3 px-4 focus:outline-none focus:ring-1 focus:ring-gray-800 text-gray-600 bg-gray-50/50 appearance-none">

                                    <option value="" disabled selected>Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white px-8 py-4 flex justify-end gap-3 rounded-b-xl mb-4">

                        <button type="button" onclick="closeModal()"
                            class="px-6 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Cancel
                        </button>

                        <button type="submit"
                            class="px-6 py-2.5 bg-[#3A3E45] rounded-lg text-sm font-medium text-white hover:bg-gray-700">
                            Submit
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div id="editModal" class="hidden fixed inset-0 z-50 overflow-y-auto">

        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeEditModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">

                <form id="editServiceForm">

                    <div class="bg-white px-8 pt-8 pb-6">

                        <h3 class="text-2xl font-bold text-gray-900 text-center mb-6">
                            Edit Services
                        </h3>

                        <div class="space-y-5">

                            <div>
                                <label class="block text-sm font-bold text-gray-800 mb-2">
                                    Service Name
                                </label>

                                <input type="text" id="edit_name" name="name" required
                                    class="block w-full border border-gray-200 rounded-lg py-3 px-4 focus:outline-none focus:ring-1 focus:ring-gray-800 text-gray-600 bg-gray-50/50">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-800 mb-2">
                                    Price
                                </label>

                                <input type="number" id="edit_price" name="price" required min="0"
                                    class="block w-full border border-gray-200 rounded-lg py-3 px-4 focus:outline-none focus:ring-1 focus:ring-gray-800 text-gray-600 bg-gray-50/50">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-800 mb-2">
                                    Description
                                </label>

                                <textarea id="edit_description" name="description" rows="3"
                                    class="block w-full border border-gray-200 rounded-lg py-3 px-4 focus:outline-none focus:ring-1 focus:ring-gray-800 text-gray-600 bg-gray-50/50"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-800 mb-2">
                                    Status
                                </label>

                                <select id="edit_status" name="status"
                                    class="block w-full border border-gray-200 rounded-lg py-3 px-4 focus:outline-none focus:ring-1 focus:ring-gray-800 text-gray-600 bg-gray-50/50">

                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white px-8 py-4 flex justify-end gap-3 rounded-b-xl mb-4">

                        <button type="button" onclick="closeEditModal()"
                            class="px-6 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Cancel
                        </button>

                        <button type="submit"
                            class="px-6 py-2.5 bg-[#3A3E45] rounded-lg text-sm font-medium text-white hover:bg-gray-700">
                            Update
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const API_URL = 'http://127.0.0.1:8000/api';

        let activeDropdown = null;
        let currentEditId = null;
        let serviceSubscriptions = {}; // Store subscription info per service

        document.addEventListener('DOMContentLoaded', () => {
            fetchServices();
            fetchSubscriptionInfo();
        });

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(angka).replace('Rp', 'Rp ');
        }

        async function fetchSubscriptionInfo() {
            try {
                const response = await fetch(`${API_URL}/subscriptions`);
                const result = await response.json();

                if (result.success) {
                    serviceSubscriptions = {};
                    result.data.forEach(sub => {
                        if (!serviceSubscriptions[sub.service_id]) {
                            serviceSubscriptions[sub.service_id] = [];
                        }
                        serviceSubscriptions[sub.service_id].push(sub.status);
                    });
                }
            } catch (error) {
                console.error('Error fetching subscriptions:', error);
            }
        }

        async function fetchServices() {
            const tableBody = document.getElementById('service-table-body');

            try {
                const response = await fetch(`${API_URL}/services`);
                const result = await response.json();

                if (result.success) {
                    renderTable(result.data);
                } else {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="4" class="text-center py-4 text-red-500">
                                Gagal load data!
                            </td>
                        </tr>
                    `;
                }

            } catch (error) {

                tableBody.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center py-4 text-red-500">
                            Koneksi gagal.
                        </td>
                    </tr>
                `;
            }
        }

        function renderTable(services) {

            const tableBody = document.getElementById('service-table-body');

            tableBody.innerHTML = '';

            if (services.length === 0) {

                tableBody.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">
                            Tidak ada data.
                        </td>
                    </tr>
                `;

                return;
            }

            services.forEach((service) => {

                const isStatusActive = service.status === true || service.status === 1;
                const hasSubscription = serviceSubscriptions[service.id] && serviceSubscriptions[service.id].length > 0;

                const checkActive = isStatusActive
                    ? '<i class="fa-solid fa-check ml-auto text-gray-800"></i>'
                    : '';

                const checkDeactive = !isStatusActive
                    ? '<i class="fa-solid fa-check ml-auto text-gray-800"></i>'
                    : '';

                const statusBadge = isStatusActive
                    ? `<span class="px-4 py-1 bg-[#E8F8EE] text-[#28A745] rounded-full text-xs font-semibold">Active</span>`
                    : `<span class="px-4 py-1 bg-red-100 text-red-600 rounded-full text-xs font-semibold">Inactive</span>`;

                // Build dropdown menu with conditional rendering
                let dropdownHTML = '';

                // Show status actions only if inactive
                if (!isStatusActive) {
                    dropdownHTML += `
                        <button onclick="changeStatus(${service.id}, true)"
                            class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                            <i class="fa-solid fa-key w-6 text-left"></i>
                            Active ${checkActive}
                        </button>
                    `;
                }

                if (isStatusActive) {
                    dropdownHTML += `
                        <button onclick="changeStatus(${service.id}, false)"
                            class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                            <i class="fa-solid fa-lock w-6 text-left"></i>
                            Deactivate ${checkDeactive}
                        </button>
                    `;
                }

                // Always show edit
                dropdownHTML += `
                    <button onclick="openEditData(${service.id})"
                        class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center mt-1">
                        <i class="fa-regular fa-pen-to-square w-6 text-left"></i>
                        Edit
                    </button>
                `;

                // Delete button - disable if has subscription
                const deleteDisabledClass = hasSubscription ? 'opacity-50 cursor-not-allowed' : '';
                const deleteTitle = hasSubscription ? 'title="Service ini memiliki subscription dan tidak bisa dihapus"' : '';

                dropdownHTML += `
                    <button onclick="deleteData(${service.id})"
                        class="w-full px-4 py-2 text-sm text-[#CC0000] hover:bg-red-50 flex items-center font-medium mt-1 ${deleteDisabledClass}"
                        ${deleteTitle}
                        ${hasSubscription ? 'disabled' : ''}>
                        <i class="fa-regular fa-trash-can w-6 text-left"></i>
                        Delete
                    </button>
                `;

                const row = document.createElement('tr');
                row.className = 'border-b border-gray-50 hover:bg-gray-50';
                row.innerHTML = `
                    <td class="py-4 px-6">${service.name}</td>
                    <td class="py-4 px-6">${formatRupiah(service.price)}</td>
                    <td class="py-4 px-6">${statusBadge}</td>

                    <td class="py-4 px-6 text-center relative">
                        <button onclick="toggleDropdown(${service.id}, event)"
                            class="text-gray-500 hover:text-gray-700 p-2">
                            <i class="fa-solid fa-bars"></i>
                        </button>

                        <div id="dropdown-${service.id}"
                            class="hidden absolute right-8 top-10 w-44 bg-white border border-gray-100 rounded-lg shadow-lg z-50 text-left py-2">
                            ${dropdownHTML}
                        </div>
                    </td>
                `;

                tableBody.appendChild(row);
            });
        }

        function toggleDropdown(id, event) {
            event.stopPropagation();

            const dropdown = document.getElementById(`dropdown-${id}`);

            if (activeDropdown && activeDropdown !== dropdown) {
                activeDropdown.classList.add('hidden');
            }

            dropdown.classList.toggle('hidden');

            activeDropdown = dropdown.classList.contains('hidden')
                ? null
                : dropdown;
        }

        document.addEventListener('click', () => {
            if (activeDropdown) {
                activeDropdown.classList.add('hidden');
                activeDropdown = null;
            }
        });

        function openModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addServiceForm').reset();
        }

        document.getElementById('addServiceForm').addEventListener('submit', async function (e) {

            e.preventDefault();

            const formData = new FormData(this);

            const data = Object.fromEntries(formData.entries());

            data.status = data.status === '1';

            data.price = parseInt(data.price);

            try {

                const response = await fetch(`${API_URL}/services`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    closeModal();
                    fetchServices();
                    fetchSubscriptionInfo();
                } else {
                    alert('Gagal nambahin data!');
                }

            } catch (error) {
                alert('Error koneksi!');
            }
        });

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        async function openEditData(id) {

            try {

                const response = await fetch(`${API_URL}/services/${id}`);

                const result = await response.json();

                if (response.ok && result.success) {

                    const svc = result.data;

                    currentEditId = svc.id;

                    document.getElementById('edit_name').value = svc.name;
                    document.getElementById('edit_price').value = svc.price;
                    document.getElementById('edit_description').value = svc.description || '';
                    document.getElementById('edit_status').value = svc.status ? '1' : '0';

                    document.getElementById('editModal').classList.remove('hidden');
                }

            } catch (error) {
                alert('Gagal ngambil data!');
            }
        }

        document.getElementById('editServiceForm').addEventListener('submit', async function (e) {

            e.preventDefault();

            const data = {
                name: document.getElementById('edit_name').value,
                price: parseInt(document.getElementById('edit_price').value),
                description: document.getElementById('edit_description').value,
                status: document.getElementById('edit_status').value === '1'
            };

            try {

                const response = await fetch(`${API_URL}/services/${currentEditId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                if (response.ok) {
                    closeEditModal();
                    fetchServices();
                    fetchSubscriptionInfo();
                } else {
                    alert('Gagal update data!');
                }

            } catch (error) {
                alert('Error koneksi!');
            }
        });

        async function changeStatus(id, isActive) {

            try {

                const response = await fetch(`${API_URL}/services/${id}/change-status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: isActive
                    })
                });

                if (response.ok) {
                    fetchServices();
                } else {
                    alert('Gagal ubah status!');
                }

            } catch (error) {
                alert('Error koneksi!');
            }
        }

        async function deleteData(id) {
            const hasSubscription = serviceSubscriptions[id] && serviceSubscriptions[id].length > 0;

            if (hasSubscription) {
                alert('Service ini memiliki subscription dan tidak bisa dihapus!');
                return;
            }

            if (confirm('Yakin mau hapus service ini?')) {

                try {

                    const response = await fetch(`${API_URL}/services/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json'
                        }
                    });

                    if (response.ok) {
                        fetchServices();
                        fetchSubscriptionInfo();
                    } else {

                        const result = await response.json();

                        alert(result.message || 'Gagal hapus data!');
                    }

                } catch (error) {
                    alert('Error koneksi!');
                }
            }
        }
    </script>
@endsection