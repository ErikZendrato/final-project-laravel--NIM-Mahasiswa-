<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased flex h-screen overflow-hidden">

    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between z-10">
        <div>
            <div class="h-16 flex items-center px-6 border-b border-gray-100">
                <div class="w-8 h-8 bg-gray-800 rounded flex items-center justify-center mr-3">
                    <div class="w-3 h-3 bg-white rounded-full"></div>
                </div>
                <span class="text-xl font-bold tracking-wider">ERP</span>
                <i class="fa-solid fa-table-columns ml-auto text-gray-400"></i>
            </div>

            <nav class="mt-6 px-4 space-y-1">
                <a href="/customers"
                    class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->is('customers*') ? 'text-gray-900 bg-gray-100' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-users w-5"></i> Customers
                </a>
                <a href="/services"
                    class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->is('services*') ? 'text-gray-900 bg-gray-100' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-cube w-5"></i> Services
                </a>
                <a href="/subscriptions"
                    class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg {{ request()->is('subscriptions*') ? 'text-gray-900 bg-gray-100' : 'text-gray-600 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-file-invoice w-5"></i> Subscription
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-gray-100">
            <a href="#"
                class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50">
                <i class="fa-solid fa-arrow-right-from-bracket w-5"></i> Sign Out
            </a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto relative">
        <header class="h-16 bg-white border-b border-gray-200 flex items-center px-8 z-10">
            <h1 class="text-sm font-medium text-gray-600">@yield('header_title')</h1>
        </header>

        <div class="p-8">
            @yield('content')
        </div>
    </main>

    @yield('scripts')
</body>

</html>