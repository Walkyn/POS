<!-- Alerts Item Success -->
<div x-data="{ showAlert: false }" x-init="if ({{ session('successMessage') ? 'true' : 'false' }}) {
    setTimeout(() => showAlert = true, 450);
    setTimeout(() => showAlert = false, 5500);
}" x-show="showAlert"
    x-transition:enter="transition transform ease-out duration-500" x-transition:enter-start="translate-x-full opacity-0"
    x-transition:enter-end="translate-x-0 opacity-100" x-transition:leave="transition transform ease-in duration-500"
    x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="translate-x-full opacity-0"
    class="flex w-full mb-6 border-l-6 border-[#34D399] bg-[#34D399] bg-opacity-[15%] px-7 py-4 shadow-md dark:bg-[#1F2937] dark:bg-opacity-30 md:p-4">
    <div class="mr-5 flex h-9 w-9 items-center justify-center rounded-lg bg-[#34D399] bg-opacity-30">
        <i class="fas fa-check-circle text-[#34D399]"></i>
    </div>
    <div class="w-full">
        <!-- Descripción -->
        <p class="text-base dark:text-[#34D399] pt-1 leading-relaxed text-body">
            {{ session('successDetails') }}
        </p>
    </div>
</div>

<!-- Alerts Item Warning -->
<div x-data="{ showAlert: false }" x-init="if ({{ session('warningMessage') ? 'true' : 'false' }}) {
    setTimeout(() => showAlert = true, 450);
    setTimeout(() => showAlert = false, 5500);
}" x-show="showAlert"
    x-transition:enter="transition transform ease-out duration-500"
    x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
    x-transition:leave="transition transform ease-in duration-500" x-transition:leave-start="opacity-100 translate-x-0"
    x-transition:leave-end="translate-x-full opacity-0"
    class="flex w-full mb-6 border-l-6 border-[#D0915C] bg-[#D0915C] bg-opacity-[15%] px-7 py-4 shadow-md dark:bg-[#1F2937] dark:bg-opacity-30 md:p-4">
    <div class="mr-5 flex h-9 w-9 items-center justify-center rounded-lg bg-[#D0915C] bg-opacity-30">
        <i class="fas fa-exclamation-triangle text-[#D0915C]"></i>
    </div>
    <div class="w-full">
        <!-- Descripción -->
        <p class="text-base dark:text-[#D0915C] pt-1 leading-relaxed text-body">
            {{ session('warningDetails') }}
        </p>
    </div>
</div>

<!-- Alerts Item Error -->
@if (session('errorDetails'))
    <div x-data="{ showAlert: false }" x-init="setTimeout(() => showAlert = true, 450);
    setTimeout(() => showAlert = false, 5500);" x-show="showAlert"
        x-transition:enter="transition transform ease-out duration-500"
        x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
        x-transition:leave="transition transform ease-in duration-500"
        x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="translate-x-full opacity-0"
        class="flex w-full mb-6 border-l-6 border-[#F87171] bg-[#F87171] bg-opacity-[15%] px-7 py-4 shadow-md dark:bg-[#1F2937] dark:bg-opacity-30 md:p-4">

        <div class="mr-5 flex h-9 w-9 items-center justify-center rounded-lg bg-[#F87171] bg-opacity-30">
            <i class="fas fa-times-circle text-[#F87171]"></i>
        </div>
        <div class="w-full">
            <!-- Descripción -->
            <p class="text-base dark:text-[#F87171] pt-1 leading-relaxed text-body">
                {{ session('errorDetails') }}
            </p>
        </div>
    </div>
@endif

<!-- Alerts Item Info -->
@if (session('infoDetails'))
    <div x-data="{ showAlert: false }" x-init="setTimeout(() => showAlert = true, 450);
    setTimeout(() => showAlert = false, 5500);" x-show="showAlert"
        x-transition:enter="transition transform ease-out duration-500"
        x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
        x-transition:leave="transition transform ease-in duration-500"
        x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="translate-x-full opacity-0"
        class="flex w-full mb-6 border-l-6 border-[#3B82F6] bg-[#3B82F6] bg-opacity-[15%] px-7 py-4 shadow-md dark:bg-[#1F2937] dark:bg-opacity-30 md:p-4">

        <div class="mr-5 flex h-9 w-9 items-center justify-center rounded-lg bg-[#3B82F6] bg-opacity-30">
            <i class="fas fa-info-circle text-[#3B82F6]"></i>
        </div>
        <div class="w-full">
            <!-- Descripción -->
            <p class="text-base dark:text-[#3B82F6] pt-1 leading-relaxed text-body">
                {{ session('infoDetails') }}
            </p>
        </div>
    </div>
@endif