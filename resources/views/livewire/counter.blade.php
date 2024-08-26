<div class="flex items-center justify-center mt-4">
    <p class="text-3xl text-black">This is my livewire component: <span class="text-blue-500">{{ $count }}</span></p>
    <div class="m-8">
        <button wire:click="increment" class="py-2 px-4 bg-cyan-400 text-white rounded-md">+</button>
        <button wire:click="decrement" class="py-2 px-4 bg-red-600 text-white rounded-md">-</button> 
    </div>
    
</div>
