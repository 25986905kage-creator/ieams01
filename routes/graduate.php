use Illuminate\Support\Facades\Route;
use App\Livewire\Graduates\Index;

Route::middleware(['auth', 'verified'])->group(function () {
    <!-- Route::get('/graduates', Index::class)->name('graduate.index'); -->
     Route::livewire('/graduates', 'graduates.index')->name('graduates.index');
});