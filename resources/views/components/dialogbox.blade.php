{{-- Dialog Box untuk Konfirmasi, Error, dan Session Messages --}}
<div 
    x-data="dialogboxData()" 
    class="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4" 
    x-show="confirm.open || error.open" 
    role="dialog" 
    aria-modal="true" 
    aria-labelledby="dialogboxTitle"
    x-cloak
    style="display: none;"
>
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm">
            <!-- Dialog Konfirmasi -->
            <template x-if="confirm.open">
                <div class="p-4 md:p-5 text-center gap-2">
                    <div class="bg-red-200 rounded-full p-3 w-12 h-12 mx-auto mb-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 id="dialogboxTitle" class="mb-5 text-lg font-normal text-gray-500">Yakin ingin menghapus data ini?</h3>
                    <button 
                        @click="closeConfirm()" 
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                        Cancel
                    </button>
                    <button 
                        @click="confirmDelete()" 
                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Hapus
                    </button>
                </div>
            </template>

            <!-- Dialog Error -->
            <template x-if="error.open">
                <div class="flex flex-col items-center p-4 md:p-5 text-center">
                    <button 
                        @click="closeError()" 
                        class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
                    >
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close dialogbox</span>
                    </button>
                    <h3 id="dialogboxTitle" class="text-xl font-bold text-gray-900 mt-2">Error</h3>
                    <div class="bg-red-200 rounded-full p-3 w-12 h-12 mx-auto my-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-pretty text-gray-700" x-text="error.message"></p>
                </div>
            </template>
        </div>
    </div>
</div>

{{-- Dialog untuk Session Success --}}
@if(session('success'))
    <div 
        x-data="{ open: true }" 
        x-init="
            if (sessionStorage.getItem('success_shown_{{ md5(session('success')) }}')) {
                open = false;
            } else {
                setTimeout(() => {
                    open = false;
                    sessionStorage.setItem('success_shown_{{ md5(session('success')) }}', 'true');
                }, 3000);
            }
        "
        x-show="open" 
        class="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4" 
        role="dialog" 
        aria-modal="true" 
        aria-labelledby="successDialogboxTitle"
        x-cloak
        style="display: none;"
    >
        <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg flex flex-col items-center">
            <h2 id="successDialogboxTitle" class="text-xl font-bold text-gray-900 sm:text-2xl text-center mt-2">Success</h2>
            <div class="my-4 flex justify-center">
                <div class="bg-green-200 rounded-full p-3">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
            <p class="text-pretty text-gray-700 text-center">{{ session('success') }}</p>
        </div>
    </div>
@endif

{{-- Dialog untuk Session Error --}}
@if(session('error'))
    <div 
        x-data="{ open: true }" 
        x-init="
            if (sessionStorage.getItem('error_shown_{{ md5(session('error')) }}')) {
                open = false;
            } else {
                setTimeout(() => {
                    open = false;
                    sessionStorage.setItem('error_shown_{{ md5(session('error')) }}', 'true');
                }, 3000);
            }
        "
        x-show="open" 
        class="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4" 
        role="dialog" 
        aria-modal="true" 
        aria-labelledby="errorDialogboxTitle"
        x-cloak
        style="display: none;"
    >
        <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg flex flex-col items-center">
            <h2 id="errorDialogboxTitle" class="text-xl font-bold text-gray-900 sm:text-2xl text-center mt-2">Error</h2>
            <div class="my-4 flex justify-center">
                <div class="bg-red-200 rounded-full p-3">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-pretty text-gray-700 text-center">{{ session('error') }}</p>
        </div>
    </div>
@endif

<script>
// Global Alpine.js component untuk dialog
window.dialogboxData = function() {
    return {
        confirm: { 
            open: false, 
            index: null, 
            id: null 
        },
        error: { 
            open: false, 
            message: '' 
        },
        
        // Method untuk membuka dialog konfirmasi
        openConfirm(index, id) {
            this.confirm.open = true;
            this.confirm.index = index;
            this.confirm.id = id;
        },
        
        // Method untuk menutup dialog konfirmasi
        closeConfirm() {
            this.confirm.open = false;
            this.confirm.index = null;
            this.confirm.id = null;
        },
        
        // Method untuk konfirmasi delete
        confirmDelete() {
            if (window.deactivateDataConfirmed) {
                window.deactivateDataConfirmed(this.confirm.index, this.confirm.id);
            }
            this.closeConfirm();
        },
        
        // Method untuk membuka dialog error
        openError(message) {
            this.error.open = true;
            this.error.message = message;
        },
        
        // Method untuk menutup dialog error
        closeError() {
            this.error.open = false;
            this.error.message = '';
        }
    }
};

// Global reference untuk dialog
window.dialogBox = null;

// Initialize dialog setelah Alpine.js ready
document.addEventListener('alpine:init', () => {
    // Set reference ke dialog component
    setTimeout(() => {
        const dialogElement = document.querySelector('[x-data="dialogboxData()"]');
        if (dialogElement && dialogElement._x_dataStack) {
            window.dialogBox = dialogElement._x_dataStack[0];
        }
    }, 100);
});
</script>