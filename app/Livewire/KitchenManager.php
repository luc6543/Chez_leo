<?php

namespace App\Livewire;

use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

/**
 * Class KitchenManager
 *
 * A Livewire component to manage kitchen and bar products.
 *
 * @package App\Livewire
 */
class KitchenManager extends Component
{
    /**
     * @var string $mode The current mode, either 'kitchen' or 'bar'.
     */
    public $mode = 'kitchen';

    /**
     * @var \Illuminate\Support\Collection $products The collection of products to be displayed.
     */
    public $products;

    /**
     * @var bool $showCompleted Flag to determine whether to show completed products.
     */
    public $showCompleted = false;

    /**
     * Render the component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.kitchen-manager');
    }

    /**
     * Lifecycle hook called when the component is mounted.
     */
    public function mount() {
        $this->refresh();
    }

    /**
     * Refresh the list of products based on the current mode and completion status.
     */
    public function refresh()
    {
        // Get products based on the current mode: kitchen = everything except drinks, bar = only drinks
        $reservations = Reservation::getCurrentReservationsQuery()->with(['bill.products' => function ($query) {
            if ($this->mode === 'kitchen') {
                $this->showCompleted == false
                    ? $query->where('category', '!=', 'drank')->where('completed', false)
                    : $query->where('category', '!=', 'drank');
            } elseif ($this->mode === 'bar') {
                $this->showCompleted == false
                    ? $query->where('category', 'drank')->where('completed', false)
                    : $query->where('category', 'drank');
            }
            else {
                $this->showCompleted == false
                    ? $query->where('completed', false)
                    : '';
            }
        }])->get();

        $products = collect();
        foreach ($reservations as $reservation) {
            if ($reservation->bill) {
                // Append each product with the table number
                $reservationProducts = $reservation->bill->products->map(function ($product) use ($reservation) {
                    $product->table_number = $reservation->table->table_number;
                    return $product;
                });

                $products = $products->merge($reservationProducts);
            }
        }

        // Group products by table_number and within each table_number group by category
        $this->products = $products->groupBy('table_number')->map(function ($tableGroup) {
            return $tableGroup->groupBy('category');
        });

    }


    /**
     * Toggle the visibility of completed products.
     */
    public function toggleCompleted() {
        $this->showCompleted = !$this->showCompleted;
        $this->refresh();
    }

    /**
     * Toggle the completed status of a product.
     *
     * @param int $pivotId The ID of the pivot row in the bill_products table.
     */
    public function complete($pivotId)
    {
        // Find the pivot row by its ID
        $pivotRow = DB::table('bill_products')->find($pivotId);

        if ($pivotRow) {
            // Toggle the 'completed' status
            DB::table('bill_products')
                ->where('id', $pivotId)
                ->update(['completed' => !$pivotRow->completed]);
        }

        // Refresh the products to reflect the updated state
        $this->refresh();
    }

    /**
     * Change the current mode and refresh the products.
     *
     * @param string $mode The new mode, either 'kitchen' or 'bar'.
     */
    public function changeMode($mode) {
        $this->mode = $mode;
        $this->refresh();
    }
}
