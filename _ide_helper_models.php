<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $delivery_order_id
 * @property string $bank_name
 * @property string $acc_holder
 * @property string $acc_num
 * @property-read \App\Models\q_delivery_orders $q_delivery_order
 * @property-read \App\Models\q_invoices $q_invoice
 * @method static \Illuminate\Database\Eloquent\Builder|BankDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|BankDetails whereAccHolder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankDetails whereAccNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankDetails whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankDetails whereDeliveryOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankDetails whereId($value)
 */
	class BankDetails extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property mixed $password
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string|null $address
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\q_invoices> $q_invoices
 * @property-read int|null $q_invoices_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\quotations> $quotations
 * @property-read int|null $quotations_count
 * @method static \Illuminate\Database\Eloquent\Builder|borrower newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|borrower newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|borrower query()
 * @method static \Illuminate\Database\Eloquent\Builder|borrower whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|borrower whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|borrower whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|borrower whereName($value)
 */
	class borrower extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $quote_id
 * @property string $issue_date
 * @property string $delivery_date
 * @property string $due_date
 * @property string $ship_by
 * @property string $ship_fee
 * @property string $c_name
 * @property string $c_no
 * @property string $c_address
 * @property string $do_total
 * @property string $notes
 * @property-read \App\Models\BankDetails|null $q_bank_details
 * @property-read \App\Models\q_invoices|null $q_invoices
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\q_items> $q_items
 * @property-read int|null $q_items_count
 * @property-read \App\Models\quotations $quotations
 * @method static \Illuminate\Database\Eloquent\Builder|q_delivery_orders newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|q_delivery_orders newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|q_delivery_orders query()
 * @method static \Illuminate\Database\Eloquent\Builder|q_delivery_orders whereCAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|q_delivery_orders whereCName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|q_delivery_orders whereCNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|q_delivery_orders whereDeliveryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|q_delivery_orders whereDoTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|q_delivery_orders whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|q_delivery_orders whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|q_delivery_orders whereIssueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|q_delivery_orders whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|q_delivery_orders whereQuoteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|q_delivery_orders whereShipBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|q_delivery_orders whereShipFee($value)
 */
	class q_delivery_orders extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $delivery_order_id
 * @property int $quote_id
 * @property string $status
 * @property string $i_total
 * @property string $issue_date
 * @property string|null $notes
 * @property-read \App\Models\BankDetails|null $q_bank_details
 * @property-read \App\Models\q_delivery_orders $q_delivery_orders
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\q_items> $q_items
 * @property-read int|null $q_items_count
 * @property-read \App\Models\quotations $quotations
 * @method static \Illuminate\Database\Eloquent\Builder|q_invoices newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|q_invoices newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|q_invoices query()
 * @method static \Illuminate\Database\Eloquent\Builder|q_invoices whereDeliveryOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|q_invoices whereITotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|q_invoices whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|q_invoices whereIssueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|q_invoices whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|q_invoices whereQuoteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|q_invoices whereStatus($value)
 */
	class q_invoices extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $quantity
 * @property string $price
 * @property string $total
 * @property int $invoice_id
 * @property int $delivery_order_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\q_delivery_orders> $q_delivery_order
 * @property-read int|null $q_delivery_order_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\q_invoices> $q_invoice
 * @property-read int|null $q_invoice_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\quotations> $quotations
 * @property-read int|null $quotations_count
 * @method static \Illuminate\Database\Eloquent\Builder|q_items newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|q_items newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|q_items query()
 * @method static \Illuminate\Database\Eloquent\Builder|q_items whereDeliveryOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|q_items whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|q_items whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|q_items whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|q_items wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|q_items whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|q_items whereTotal($value)
 */
	class q_items extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $logo
 * @property string $subject
 * @property string $address
 * @property string $email
 * @property string $issue_date
 * @property string $valid_date
 * @property int $status
 * @property string $q_total
 * @property string $c_name
 * @property string $c_address
 * @property string $c_no
 * @property string|null $notes
 * @property int $borrower_id
 * @property-read \App\Models\borrower $borrower
 * @property-read \App\Models\q_delivery_orders|null $q_delivery_orders
 * @property-read \App\Models\q_invoices|null $q_invoices
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\q_items> $q_items
 * @property-read int|null $q_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|quotations newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|quotations newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|quotations query()
 * @method static \Illuminate\Database\Eloquent\Builder|quotations whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quotations whereBorrowerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quotations whereCAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quotations whereCName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quotations whereCNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quotations whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quotations whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quotations whereIssueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quotations whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quotations whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quotations whereQTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quotations whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quotations whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quotations whereValidDate($value)
 */
	class quotations extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $quote_id
 * @property int $item_id
 * @method static \Illuminate\Database\Eloquent\Builder|quote_items newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|quote_items newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|quote_items query()
 * @method static \Illuminate\Database\Eloquent\Builder|quote_items whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|quote_items whereQuoteId($value)
 */
	class quote_items extends \Eloquent {}
}

