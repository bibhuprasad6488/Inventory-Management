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
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $img_path
 * @property int|null $parent_category
 * @property string $status 0=>Inactive, 1=>Active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Category|null $parentCategory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $subCategories
 * @property-read int|null $sub_categories_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereImgPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereParentCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $order_number
 * @property numeric $amount
 * @property string $mode_of_payment
 * @property string|null $order_date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderDetail> $orderDetails
 * @property-read int|null $order_details_count
 * @property-read \App\Models\User|null $retailer
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereModeOfPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereOrderDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUserId($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property string|null $product_name
 * @property string|null $pack_size
 * @property int|null $qty
 * @property numeric $cost_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail wherePackSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderDetail whereUpdatedAt($value)
 */
	class OrderDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $qty
 * @property string $status 0=>Inactive, 1=>Active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PackSize newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PackSize newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PackSize query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PackSize whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PackSize whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PackSize whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PackSize whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PackSize whereUpdatedAt($value)
 */
	class PackSize extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $order_number
 * @property int $order_id
 * @property numeric $received_amount
 * @property string $mode_of_payment
 * @property string|null $received_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentCollection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentCollection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentCollection query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentCollection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentCollection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentCollection whereModeOfPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentCollection whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentCollection whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentCollection whereReceivedAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentCollection whereReceivedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentCollection whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentCollection whereUserId($value)
 */
	class PaymentCollection extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $category_id
 * @property string|null $hsn
 * @property string|null $product_name
 * @property string|null $slug
 * @property string|null $image
 * @property string|null $description
 * @property string|null $pack_size
 * @property int $stock
 * @property numeric $mrp
 * @property numeric $cost_price
 * @property numeric $selling_price
 * @property int $vat
 * @property string $status 0=>Inactive, 1=>Active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @property-read \App\Models\PackSize|null $packSize
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCostPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereHsn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMrp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePackSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSellingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereVat($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $push_token
 * @property string $platform
 * @property string|null $device_name
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PushNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PushNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PushNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PushNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PushNotification whereDeviceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PushNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PushNotification whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PushNotification wherePlatform($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PushNotification wherePushToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PushNotification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PushNotification whereUserId($value)
 */
	class PushNotification extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $site_title
 * @property string|null $site_logo
 * @property string|null $footer_logo
 * @property string|null $footer_logo_one
 * @property string|null $footer_logo_two
 * @property string|null $favicon
 * @property string|null $contact_email
 * @property string|null $alt_email
 * @property string|null $contact_phone
 * @property string|null $alt_phone
 * @property string|null $call_wp_number
 * @property string|null $wp_message
 * @property string|null $copyright
 * @property string|null $commision
 * @property string|null $site_desc
 * @property string|null $site_map_key
 * @property string|null $address
 * @property string|null $site_meta_desc
 * @property string|null $site_meta_key
 * @property string|null $smtp_host
 * @property string|null $smtp_port
 * @property string|null $smtp_username
 * @property string|null $smtp_password
 * @property string|null $smtp_from_name
 * @property string|null $smtp_from_email
 * @property string $partner_show
 * @property string|null $cta_title
 * @property string|null $cta_sub_title
 * @property string|null $footer_text_one
 * @property string|null $footer_text_two
 * @property string|null $social_links
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereAltEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereAltPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereCallWpNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereCommision($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereContactEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereCopyright($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereCtaSubTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereCtaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereFavicon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereFooterLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereFooterLogoOne($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereFooterLogoTwo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereFooterTextOne($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereFooterTextTwo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting wherePartnerShow($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereSiteDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereSiteLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereSiteMapKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereSiteMetaDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereSiteMetaKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereSiteTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereSmtpFromEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereSmtpFromName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereSmtpHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereSmtpPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereSmtpPort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereSmtpUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereSocialLinks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereWpMessage($value)
 */
	class SiteSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $product_id
 * @property string $trans_type
 * @property string|null $qty
 * @property string|null $refrence
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockHistory whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockHistory whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockHistory whereRefrence($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockHistory whereTransType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockHistory whereUpdatedAt($value)
 */
	class StockHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $billing_name
 * @property string $email
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $role_id
 * @property string|null $billing_address
 * @property numeric $due_amount
 * @property string|null $gst_number
 * @property string $status
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property-read \App\Models\Role|null $role
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBillingAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBillingName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDueAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereGstNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

