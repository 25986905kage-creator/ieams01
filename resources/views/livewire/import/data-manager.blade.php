<div>
    <div class="mb-8">
        <flux:heading size="xl">Data Manager</flux:heading>
        <flux:subheading>Import historical graduate data into the IEAMS relational database.</flux:subheading>
    </div>

    <div class="max-w-2xl">
        <flux:card>
            <form wire:submit="processImport" class="flex flex-col gap-6">
                
                @if($importSuccess)
                    <div class="p-4 rounded-lg bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 flex items-center gap-3">
                        <flux:icon.check-circle class="w-5 h-5" />
                        <span class="font-medium">Data imported successfully! The dashboard has been updated.</span>
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Upload Spreadsheet (CSV, XLSX)
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-zinc-300 dark:border-zinc-700 border-dashed rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                        <div class="space-y-1 text-center">
                            <flux:icon.document-arrow-up class="mx-auto h-12 w-12 text-zinc-400" />
                            <div class="flex text-sm text-zinc-600 dark:text-zinc-400 justify-center">
                                <label for="file-upload" class="relative cursor-pointer rounded-md font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Upload a file</span>
                                    <input id="file-upload" wire:model="importFile" type="file" class="sr-only" accept=".csv, .xlsx, .xls">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-zinc-500">
                                Max file size: 10MB
                            </p>
                        </div>
                    </div>
                    @error('importFile') 
                        <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> 
                    @enderror
                </div>

                @if ($importFile)
                    <div class="text-sm text-zinc-600 dark:text-zinc-400 flex items-center gap-2">
                        <flux:icon.paper-clip class="w-4 h-4" />
                        Ready to process: <span class="font-semibold">{{ $importFile->getClientOriginalName() }}</span>
                    </div>
                @endif

                <div class="flex justify-end pt-4 border-t border-zinc-200 dark:border-zinc-700">
                    <flux:button 
                        type="submit" 
                        variant="primary" 
                        icon="server-stack"
                        wire:loading.attr="disabled"
                        wire:target="processImport"
                    >
                        <span wire:loading.remove wire:target="processImport">Run Import Pipeline</span>
                        <span wire:loading wire:target="processImport">Processing Rows...</span>
                    </flux:button>
                </div>

            </form>
        </flux:card>
    </div>
</div>