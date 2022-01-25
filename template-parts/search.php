<div class="search-form flex flex-col w-full relative">
    <div class="flex flex-row items-center justify-center space-x-4 bg-neutral-12 rounded-full px-8 py-2">
        <i class="fas fa-search text-primary-4"></i>
        <label>
            <input id="input-search" type="text" placeholder="Buscar..." class="w-64 h-8 outline-none text-neutral-1"/>
        </label>
        <i class="fas fa-times reset-form text-primary-4 opacity-0"></i>
    </div>
    <div>
        <div id="results-query"
             class="w-4/5 h-48 opacity-0 inset-x-0 mx-auto absolute transition-all duration-200 ease-in-out overflow-hidden">
            <div class="main-content w-full h-full relative">
                <div class="content w-full h-full bg-neutral-12 rounded-b-lg absolute overflow-y-auto">
                    <ul class="py-2"></ul>
                    <a href="javascript:void(0)" data-search="" data-page=""
                       class="load-more font-bold text-neutral-3 text-center hidden">ver más</a>
                </div>
            </div>
        </div>
    </div>
</div>
