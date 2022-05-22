<?php

namespace App\Observers;

use App\Models\Customer;
//Import SMS Controller
use App\Http\Controllers\Api\SMSController;

class CustomerObserver
{
    /**
     * Handle the Customer "created" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function created(Customer $customer)
    {
        //
    }

    /**
     * Handle the Customer "updated" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function updating(Customer $customer)
    {
        $newStatus = $customer->status;
        $oldStatus = $customer->getOriginal('status');
        if($newStatus !== $oldStatus) {

            $changedStatus = ($newStatus == 'ACTIVE') ? 'activated' : ($newStatus == 'SUSPENDED' ? 'suspended' : 'deleted');
            //Compose SMS for customer
            $sms = "Dear {$customer->firstname}, your account has been {$changedStatus}. If this is an error, please contact us immediately.";
            //Send SMS to customer
            SMSController::sendSMS($customer->msisdn, $sms);
        }
    }

    /**
     * Handle the Customer "deleted" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function deleted(Customer $customer)
    {
        //
    }

    /**
     * Handle the Customer "restored" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function restored(Customer $customer)
    {
        //
    }

    /**
     * Handle the Customer "force deleted" event.
     *
     * @param  \App\Models\Customer  $customer
     * @return void
     */
    public function forceDeleted(Customer $customer)
    {
        //
    }
}
