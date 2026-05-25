@extends('layouts.app')

@section('title', 'Subscriptions')
@section('header_title', 'Subscriptions')

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
                    <th class="py-4 px-6 font-medium">Customer Name</th>
                    <th class="py-4 px-6 font-medium">Services</th>
                    <th class="py-4 px-6 font-medium">Services Period</th>
                    <th class="py-4 px-6 font-medium">Status</th>
                    <th class="py-4 px-6 font-medium text-center">Action</th>
                </tr>
            </thead>
            <tbody id="subscription-table-body" class="text-sm text-gray-700">
                <tr>
                    <td colspan="5" class="text-center py-8 text-gray-400">Loading data...</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div id="addModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                <form id="addSubscriptionForm">
                    <div class="bg-white px-8 pt-8 pb-6">
                        <h3 class="text-2xl font-bold text-gray-900 text-center mb-6">Add Subscription</h3>

                        <div class="space-y-5">

                            <div>
                                <label class="block text-sm font-bold text-gray-800 mb-2">Customer</label>

                                <select id="select_customer" name="customer_id" required
                                    class="block w-full border border-gray-200 rounded-lg py-3 px-4 focus:outline-none focus:ring-1 focus:ring-gray-800 text-gray-600 bg-gray-50/50 appearance-none">
                                    <option value="" disabled selected>Select Customer</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-800 mb-2">Service</label>

                                <select id="select_service" name="service_id" required
                                    class="block w-full border border-gray-200 rounded-lg py-3 px-4 focus:outline-none focus:ring-1 focus:ring-gray-800 text-gray-600 bg-gray-50/50 appearance-none">
                                    <option value="" disabled selected>Select Service</option>
                                </select>
                            </div>

                            <div class="flex gap-4">
                                <div class="w-1/2">
                                    <label class="block text-sm font-bold text-gray-800 mb-2">Start Date</label>

                                    <input type="date" name="start_date" required
                                        class="block w-full border border-gray-200 rounded-lg py-3 px-4 focus:outline-none text-gray-600 bg-gray-50/50">
                                </div>

                                <div class="w-1/2">
                                    <label class="block text-sm font-bold text-gray-800 mb-2">End Date</label>

                                    <input type="date" name="end_date" required
                                        class="block w-full border border-gray-200 rounded-lg py-3 px-4 focus:outline-none text-gray-600 bg-gray-50/50">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-800 mb-2">Status</label>

                                <select name="status" required
                                    class="block w-full border border-gray-200 rounded-lg py-3 px-4 focus:outline-none focus:ring-1 focus:ring-gray-800 text-gray-600 bg-gray-50/50 appearance-none">
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="trial">Trial</option>
                                    <option value="isolir">Isolir</option>
                                    <option value="dismantle">Dismantle</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="bg-white px-8 py-4 flex justify-end gap-3 rounded-b-xl mb-4">
                        <button type="button" onclick="closeModal()"
                            class="px-6 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700">
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
@endsection

@section('scripts')
    <script>
        const API_URL = 'http://127.0.0.1:8000/api';
        let activeDropdown = null;

        document.addEventListener('DOMContentLoaded', () => {
            fetchSubscriptions();
            loadSelectOptions();
        });

        function formatDate(dateString) {
            if (!dateString) return '-';

            const date = new Date(dateString);

            return date.toLocaleDateString('en-GB', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });
        }

        function getStatusBadge(status) {
            const s = status ? status.toLowerCase() : '';

            if (s === 'active') {
                return `<span class="px-3 py-1 bg-[#E8F8EE] text-[#28A745] rounded-full text-xs font-semibold capitalize">${status}</span>`;
            }

            if (s === 'trial') {
                return `<span class="px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-semibold capitalize">${status}</span>`;
            }

            if (s === 'isolir' || s === 'inactive' || s === 'deactivate') {
                return `<span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-semibold capitalize">${status}</span>`;
            }

            if (s === 'dismantle') {
                return `<span class="px-3 py-1 bg-gray-200 text-gray-500 rounded-full text-xs font-semibold capitalize">${status}</span>`;
            }

            return `<span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-semibold capitalize">${status}</span>`;
        }

        async function fetchSubscriptions() {
            const tableBody = document.getElementById('subscription-table-body');

            try {
                const response = await fetch(`${API_URL}/subscriptions`);
                const result = await response.json();

                if (result.success) {
                    renderTable(result.data);
                } else {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="5" class="text-center py-4 text-red-500">
                                Gagal load data!
                            </td>
                        </tr>
                    `;
                }

            } catch (error) {

                tableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center py-4 text-red-500">
                            Koneksi gagal.
                        </td>
                    </tr>
                `;
            }
        }

        function renderTable(subscriptions) {
            const tableBody = document.getElementById('subscription-table-body');
            tableBody.innerHTML = '';

            if (subscriptions.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="5" class="text-center py-4 text-gray-500">Tidak ada data.</td></tr>`;
                return;
            }

            subscriptions.forEach((sub) => {
                const customerName = sub.customer ? sub.customer.name : 'Unknown Customer';
                const serviceName = sub.service ? sub.service.name : 'Unknown Service';
                const period = `${formatDate(sub.start_date)} - ${formatDate(sub.end_date)}`;

                const currentStatus = sub.status ? sub.status.toLowerCase() : '';
                const isDismantle = currentStatus === 'dismantle';

                // Build dropdown menu with conditional rendering
                let dropdownHTML = '';

                // Show status change buttons only if NOT dismantled
                if (!isDismantle) {
                    const checkActive = currentStatus === 'active'
                        ? '<i class="fa-solid fa-check ml-auto text-gray-800"></i>'
                        : '';

                    const checkInactive = currentStatus === 'inactive'
                        ? '<i class="fa-solid fa-check ml-auto text-gray-800"></i>'
                        : '';

                    const checkTrial = currentStatus === 'trial'
                        ? '<i class="fa-solid fa-check ml-auto text-gray-800"></i>'
                        : '';

                    const checkIsolir = currentStatus === 'isolir'
                        ? '<i class="fa-solid fa-check ml-auto text-gray-800"></i>'
                        : '';

                    dropdownHTML += `
                        <button onclick="changeStatus(${sub.id}, 'active')" 
                            class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                            <i class="fa-solid fa-key w-6 text-left"></i>
                            Active
                            ${checkActive}
                        </button>

                        <button onclick="changeStatus(${sub.id}, 'inactive')" 
                            class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                            <i class="fa-solid fa-lock w-6 text-left"></i>
                            Inactive
                            ${checkInactive}
                        </button>

                        <button onclick="changeStatus(${sub.id}, 'trial')" 
                            class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                            <i class="fa-solid fa-hourglass-half w-6 text-left"></i>
                            Trial
                            ${checkTrial}
                        </button>

                        <button onclick="changeStatus(${sub.id}, 'isolir')" 
                            class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                            <i class="fa-regular fa-circle-dot w-6 text-left"></i>
                            Isolir
                            ${checkIsolir}
                        </button>
                    `;
                }

                // Dismantle button - always shown (and only clickable if not already dismantled)
                const checkDismantle = currentStatus === 'dismantle'
                    ? '<i class="fa-solid fa-check ml-auto text-gray-800"></i>'
                    : '';

                if (!isDismantle) {
                    dropdownHTML += `
                        <button onclick="changeStatus(${sub.id}, 'dismantle')" 
                            class="w-full px-4 py-2 text-sm text-[#CC0000] hover:bg-red-50 flex items-center font-medium">
                            <i class="fa-regular fa-circle-xmark w-6 text-left"></i>
                            Dismantle
                            ${checkDismantle}
                        </button>
                    `;
                } else {
                    dropdownHTML += `
                        <button class="w-full px-4 py-2 text-sm text-gray-400 cursor-not-allowed flex items-center font-medium opacity-50">
                            <i class="fa-regular fa-circle-xmark w-6 text-left"></i>
                            Dismantle
                            ${checkDismantle}
                        </button>
                        <div class="px-4 py-2 text-xs text-gray-500 bg-gray-50 border-t border-gray-100">
                            Status sudah dismantle, tidak bisa diubah lagi
                        </div>
                    `;
                }

                const row = document.createElement('tr');
                row.className = 'border-b border-gray-50 hover:bg-gray-50';

                row.innerHTML = `
                    <td class="py-4 px-6">${customerName}</td>
                    <td class="py-4 px-6">${serviceName}</td>
                    <td class="py-4 px-6">${period}</td>
                    <td class="py-4 px-6">${getStatusBadge(sub.status)}</td>

                    <td class="py-4 px-6 text-center relative">
                        <button onclick="toggleDropdown(${sub.id}, event)" class="text-gray-500 hover:text-gray-700 p-2">
                            <i class="fa-solid fa-bars"></i>
                        </button>

                        <div id="dropdown-${sub.id}" class="hidden absolute right-8 top-10 w-48 bg-white border border-gray-100 rounded-lg shadow-lg z-50 text-left py-2">
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

        async function loadSelectOptions() {

            try {

                // CUSTOMER ACTIVE ONLY
                const custRes = await fetch(`${API_URL}/customers?status=active`);
                const custData = await custRes.json();

                const custSelect = document.getElementById('select_customer');

                if (custData.success) {

                    custSelect.innerHTML = `
                        <option value="" disabled selected>
                            Select Customer
                        </option>
                    `;

                    custData.data.forEach(c => {

                        custSelect.innerHTML += `
                            <option value="${c.id}">
                                ${c.name}
                            </option>
                        `;
                    });
                }

                // SERVICE ACTIVE ONLY
                const servRes = await fetch(`${API_URL}/services?status=active`);
                const servData = await servRes.json();

                const servSelect = document.getElementById('select_service');

                if (servData.success) {

                    servSelect.innerHTML = `
                        <option value="" disabled selected>
                            Select Service
                        </option>
                    `;

                    servData.data.forEach(s => {

                        servSelect.innerHTML += `
                            <option value="${s.id}">
                                ${s.name}
                            </option>
                        `;
                    });
                }

            } catch (error) {

                console.error(error);
            }
        }

        function openModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addSubscriptionForm').reset();
        }

        document.getElementById('addSubscriptionForm').addEventListener('submit', async function (e) {

            e.preventDefault();

            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            try {

                const response = await fetch(`${API_URL}/subscriptions`, {
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
                    fetchSubscriptions();

                } else {

                    alert('Gagal nambahin data!');
                }

            } catch (error) {

                alert('Error koneksi!');
            }
        });

        async function changeStatus(id, newStatus) {

            try {

                const response = await fetch(`${API_URL}/subscriptions/${id}/change-status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                });

                if (response.ok) {

                    fetchSubscriptions();

                } else {

                    const result = await response.json();

                    alert(result.message || 'Gagal ubah status!');
                }

            } catch (error) {

                alert('Error koneksi!');
            }
        }
    </script>
@endsection