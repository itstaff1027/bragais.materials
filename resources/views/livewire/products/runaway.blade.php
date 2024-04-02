<div>
    <div>
        Generate Code!
        <form wire:submit.prevent='addUniqueCode'>
            <input type="text" class="rounded-md border-2 border-slate-500" wire:model='quantity' placeholder="Quantity" />
            <input type="text" class="rounded-md border-2 border-slate-500" wire:model='po_number' placeholder="PO Number" />
            <button type="submit">Save</button>
        </form>
    </div>
    <div class="flex flex-col">
        <div class="w-full border-2 m-2 p-2 h-96 overflow-y-auto">
            <table class="table-fixed w-full">
                <thead> 
                    <tr>
                        <th>ID</th>
                        <th>UUID</th>
                        <th>LEFT</th>
                        <th>RIGHT</th>
                        <th>BOX</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                        <td>test</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
