import "./bootstrap.js";

// import Clipboard from '@ryangjchandler/alpine-clipboard.js'
import Alpine from "alpinejs";
// import Livewire from "livewire";

window.Alpine = Alpine;
Alpine.plugin(Focus);

window.Livewire = Livewire;
Livewire.start();

Alpine.start();

// Livewire.start()
