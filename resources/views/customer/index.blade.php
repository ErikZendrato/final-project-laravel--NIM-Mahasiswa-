@extends('layouts.app')

@section('title', 'Customers')
@section('header_title', 'Customers')

@section('content')
    <div class="flex justify-end mb-6">
        <button onclick="openModal()"
            class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center shadow-sm">
            <i class="fa-solid fa-plus mr-2"></i> Add Data
        </button>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-visible relative">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-100 text-gray-500 text-sm">
                    <th class="py-4 px-6 font-medium">Customer ID</th>
                    <th class="py-4 px-6 font-medium">Customer Name</th>
                    <th class="py-4 px-6 font-medium">Email</th>
                    <th class="py-4 px-6 font-medium">Address</th>
                    <th class="py-4 px-6 font-medium">Status</th>
                    <th class="py-4 px-6 font-medium text-center">Action</th>
                </tr>
            </thead>
            <tbody id="customer-table-body" class="text-sm text-gray-700">
                <tr>
                    <td colspan="6" class="text-center py-8 text-gray-400">Loading data...</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div id="addModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="addCustomerForm">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Add New Customer</h3>

                        <div class="space-y-4">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Customer ID
                                </label>

                                <input type="text" id="customer_id_preview" value="Loading..." readonly
                                    class="block w-full border border-gray-200 bg-gray-100 rounded-md py-2 px-3 text-gray-500 cursor-not-allowed">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Customer Name
                                </label>

                                <input type="text" name="name" required
                                    class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-gray-800">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Email
                                </label>

                                <input type="email" name="email"
                                    class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-gray-800">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Phone
                                </label>

                                <input type="text" name="phone"
                                    class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-gray-800">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Address
                                </label>

                                <textarea name="address" rows="2"
                                    class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-gray-800"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Status
                                </label>

                                <select name="status"
                                    class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-gray-800">

                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>

                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">

                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-white hover:bg-gray-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">

                            Save Data
                        </button>

                        <button type="button" onclick="closeModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">

                            Cancel
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="editModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeEditModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">

                <form id="editCustomerForm">

                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">

                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            Edit Customer
                        </h3>

                        <div class="space-y-4">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Customer ID (Read Only)
                                </label>

                                <input type="text" id="edit_customer_id" readonly
                                    class="block w-full border border-gray-200 bg-gray-100 rounded-md py-2 px-3 text-gray-500 sm:text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Customer Name
                                </label>

                                <input type="text" id="edit_name" name="name" required
                                    class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-gray-800">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Email
                                </label>

                                <input type="email" id="edit_email" name="email"
                                    class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-gray-800">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Phone
                                </label>

                                <input type="text" id="edit_phone" name="phone"
                                    class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-gray-800">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Address
                                </label>

                                <textarea id="edit_address" name="address" rows="2"
                                    class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-gray-800"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Status
                                </label>

                                <select id="edit_status" name="status"
                                    class="block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-1 focus:ring-gray-800">

                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>

                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">

                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-white hover:bg-gray-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">

                            Update Data
                        </button>

                        <button type="button" onclick="closeEditModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">

                            Cancel
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

        document.addEventListener('DOMContentLoaded', fetchCustomers);

        async function fetchCustomers() {
            const tableBody = document.getElementById('customer-table-body');

            try {
                const response = await fetch(`${API_URL}/customers`);
                const result = await response.json();

                if (result.success) {
                    renderTable(result.data);
                } else {
                    tableBody.innerHTML =
                        `<tr><td colspan="6" class="text-center py-4 text-red-500">Gagal load data!</td></tr>`;
                }

            } catch (error) {
                tableBody.innerHTML =
                    `<tr><td colspan="6" class="text-center py-4 text-red-500">Koneksi ke backend gagal.</td></tr>`;
            }
        }

        function renderTable(customers) {
            const tableBody = document.getElementById('customer-table-body');

            tableBody.innerHTML = '';

            if (customers.length === 0) {
                tableBody.innerHTML =
                    `<tr><td colspan="6" class="text-center py-4 text-gray-500">Tidak ada data customer.</td></tr>`;
                return;
            }

            customers.forEach((customer) => {

                const isStatusActive = customer.status === true || customer.status === 1;

                const checkActive = isStatusActive
                    ? '<i class="fa-solid fa-check ml-auto text-gray-800"></i>'
                    : '';

                const checkDeactive = !isStatusActive
                    ? '<i class="fa-solid fa-check ml-auto text-gray-800"></i>'
                    : '';

                const statusBadge = isStatusActive
                    ? `<span class="px-3 py-1 bg-[#E8F8EE] text-[#28A745] rounded-full text-xs font-semibold">Active</span>`
                    : `<span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-semibold">Inactive</span>`;

                const row = document.createElement('tr');

                row.className = 'border-b border-gray-50 hover:bg-gray-50';

                row.innerHTML = `
                    <td class="py-4 px-6">${customer.customer_id}</td>
                    <td class="py-4 px-6">${customer.name}</td>
                    <td class="py-4 px-6">${customer.email || '-'}</td>
                    <td class="py-4 px-6 truncate max-w-xs">${customer.address || '-'}</td>
                    <td class="py-4 px-6">${statusBadge}</td>

                    <td class="py-4 px-6 text-center relative">

                        <button onclick="toggleDropdown(${customer.id}, event)"
                            class="text-gray-500 hover:text-gray-700 p-2">

                            <i class="fa-solid fa-bars"></i>
                        </button>

                        <div id="dropdown-${customer.id}"
                            class="hidden absolute right-8 top-10 w-44 bg-white border border-gray-100 rounded-lg shadow-lg z-50 text-left py-2">

                            <button onclick="changeStatus(${customer.id}, true)"
                                class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">

                                <i class="fa-solid fa-key w-6 text-left"></i>
                                Active ${checkActive}
                            </button>

                            <button onclick="changeStatus(${customer.id}, false)"
                                class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">

                                <i class="fa-solid fa-lock w-6 text-left"></i>
                                Deactivate ${checkDeactive}
                            </button>

                            <button onclick="openEditData(${customer.id})"
                                class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center mt-1">

                                <i class="fa-regular fa-pen-to-square w-6 text-left"></i>
                                Edit
                            </button>

                            <button onclick="deleteData(${customer.id})"
                                class="w-full px-4 py-2 text-sm text-[#CC0000] hover:bg-red-50 flex items-center font-medium mt-1">

                                <i class="fa-regular fa-trash-can w-6 text-left"></i>
                                Delete
                            </button>

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

        async function openModal() {

            document.getElementById('addModal').classList.remove('hidden');

            try {

                const response = await fetch(`${API_URL}/customers-next-id`);
                const result = await response.json();

                if (result.success) {
                    document.getElementById('customer_id_preview').value =
                        result.customer_id;
                } else {
                    document.getElementById('customer_id_preview').value = 'ERROR';
                }

            } catch (error) {
                document.getElementById('customer_id_preview').value = 'ERROR';
            }
        }

        function closeModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addCustomerForm').reset();
        }

        document.getElementById('addCustomerForm').addEventListener('submit', async function (e) {

            e.preventDefault();

            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            data.status = data.status === '1';

            try {

                const response = await fetch(`${API_URL}/customers`, {
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
                    fetchCustomers();
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

                const response = await fetch(`${API_URL}/customers/${id}`);
                const result = await response.json();

                if (response.ok && result.success) {

                    const cust = result.data;

                    currentEditId = cust.id;

                    document.getElementById('edit_customer_id').value = cust.customer_id;
                    document.getElementById('edit_name').value = cust.name;
                    document.getElementById('edit_email').value = cust.email || '';
                    document.getElementById('edit_phone').value = cust.phone || '';
                    document.getElementById('edit_address').value = cust.address || '';
                    document.getElementById('edit_status').value = cust.status ? '1' : '0';

                    document.getElementById('editModal').classList.remove('hidden');
                }

            } catch (error) {
                alert('Gagal ngambil data!');
            }
        }

        document.getElementById('editCustomerForm').addEventListener('submit', async function (e) {

            e.preventDefault();

            const data = {
                name: document.getElementById('edit_name').value,
                email: document.getElementById('edit_email').value,
                phone: document.getElementById('edit_phone').value,
                address: document.getElementById('edit_address').value,
                status: document.getElementById('edit_status').value === '1'
            };

            try {

                const response = await fetch(`${API_URL}/customers/${currentEditId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                if (response.ok) {
                    closeEditModal();
                    fetchCustomers();
                } else {
                    alert('Gagal update data!');
                }

            } catch (error) {
                alert('Error koneksi!');
            }
        });

        async function changeStatus(id, isActive) {

            try {

                const response = await fetch(`${API_URL}/customers/${id}/change-status`, {
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
                    fetchCustomers();
                } else {
                    alert('Gagal ubah status!');
                }

            } catch (error) {
                alert('Error koneksi!');
            }
        }

        async function deleteData(id) {

            if (confirm('Yakin mau hapus customer ini?')) {

                try {

                    const response = await fetch(`${API_URL}/customers/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json'
                        }
                    });

                    if (response.ok) {
                        fetchCustomers();
                    } else {
                        alert('Gagal hapus data!');
                    }

                } catch (error) {
                    alert('Error koneksi!');
                }
            }
        }
    </script>
@endsection