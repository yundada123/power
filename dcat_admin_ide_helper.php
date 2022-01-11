<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection pid
     * @property Grid\Column|Collection uid
     * @property Grid\Column|Collection before
     * @property Grid\Column|Collection balance
     * @property Grid\Column|Collection after
     * @property Grid\Column|Collection aid
     * @property Grid\Column|Collection orderid
     * @property Grid\Column|Collection xftype
     * @property Grid\Column|Collection deleted_at
     * @property Grid\Column|Collection role
     * @property Grid\Column|Collection power_par
     * @property Grid\Column|Collection user
     * @property Grid\Column|Collection pwd
     * @property Grid\Column|Collection admin_url
     * @property Grid\Column|Collection api_acco
     * @property Grid\Column|Collection api_key
     * @property Grid\Column|Collection api_url
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection desc
     * @property Grid\Column|Collection discount
     * @property Grid\Column|Collection amount
     * @property Grid\Column|Collection aamount
     * @property Grid\Column|Collection bamount
     * @property Grid\Column|Collection uuid
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection province_name
     * @property Grid\Column|Collection acco
     * @property Grid\Column|Collection kk_amount
     * @property Grid\Column|Collection msg
     * @property Grid\Column|Collection p_order_id
     * @property Grid\Column|Collection u_order_id
     * @property Grid\Column|Collection order_price
     * @property Grid\Column|Collection notify
     * @property Grid\Column|Collection shop_id
     * @property Grid\Column|Collection notify_status
     * @property Grid\Column|Collection notify_msg
     * @property Grid\Column|Collection province
     * @property Grid\Column|Collection c_id
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection tokenable_type
     * @property Grid\Column|Collection tokenable_id
     * @property Grid\Column|Collection abilities
     * @property Grid\Column|Collection last_used_at
     * @property Grid\Column|Collection power_id
     * @property Grid\Column|Collection show_name
     * @property Grid\Column|Collection shop_name
     * @property Grid\Column|Collection shop_price
     * @property Grid\Column|Collection shop_type
     * @property Grid\Column|Collection shop_par
     * @property Grid\Column|Collection shop_discount
     * @property Grid\Column|Collection shop_msg
     * @property Grid\Column|Collection shop_pic
     * @property Grid\Column|Collection href
     * @property Grid\Column|Collection target
     * @property Grid\Column|Collection sort
     * @property Grid\Column|Collection remark
     * @property Grid\Column|Collection create_at
     * @property Grid\Column|Collection update_at
     * @property Grid\Column|Collection delete_at
     * @property Grid\Column|Collection sequence
     * @property Grid\Column|Collection batch_id
     * @property Grid\Column|Collection family_hash
     * @property Grid\Column|Collection should_display_on_index
     * @property Grid\Column|Collection content
     * @property Grid\Column|Collection entry_uuid
     * @property Grid\Column|Collection tag
     * @property Grid\Column|Collection apikey
     * @property Grid\Column|Collection email_verified_at
     *
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection pid(string $label = null)
     * @method Grid\Column|Collection uid(string $label = null)
     * @method Grid\Column|Collection before(string $label = null)
     * @method Grid\Column|Collection balance(string $label = null)
     * @method Grid\Column|Collection after(string $label = null)
     * @method Grid\Column|Collection aid(string $label = null)
     * @method Grid\Column|Collection orderid(string $label = null)
     * @method Grid\Column|Collection xftype(string $label = null)
     * @method Grid\Column|Collection deleted_at(string $label = null)
     * @method Grid\Column|Collection role(string $label = null)
     * @method Grid\Column|Collection power_par(string $label = null)
     * @method Grid\Column|Collection user(string $label = null)
     * @method Grid\Column|Collection pwd(string $label = null)
     * @method Grid\Column|Collection admin_url(string $label = null)
     * @method Grid\Column|Collection api_acco(string $label = null)
     * @method Grid\Column|Collection api_key(string $label = null)
     * @method Grid\Column|Collection api_url(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection desc(string $label = null)
     * @method Grid\Column|Collection discount(string $label = null)
     * @method Grid\Column|Collection amount(string $label = null)
     * @method Grid\Column|Collection aamount(string $label = null)
     * @method Grid\Column|Collection bamount(string $label = null)
     * @method Grid\Column|Collection uuid(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection province_name(string $label = null)
     * @method Grid\Column|Collection acco(string $label = null)
     * @method Grid\Column|Collection kk_amount(string $label = null)
     * @method Grid\Column|Collection msg(string $label = null)
     * @method Grid\Column|Collection p_order_id(string $label = null)
     * @method Grid\Column|Collection u_order_id(string $label = null)
     * @method Grid\Column|Collection order_price(string $label = null)
     * @method Grid\Column|Collection notify(string $label = null)
     * @method Grid\Column|Collection shop_id(string $label = null)
     * @method Grid\Column|Collection notify_status(string $label = null)
     * @method Grid\Column|Collection notify_msg(string $label = null)
     * @method Grid\Column|Collection province(string $label = null)
     * @method Grid\Column|Collection c_id(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection tokenable_type(string $label = null)
     * @method Grid\Column|Collection tokenable_id(string $label = null)
     * @method Grid\Column|Collection abilities(string $label = null)
     * @method Grid\Column|Collection last_used_at(string $label = null)
     * @method Grid\Column|Collection power_id(string $label = null)
     * @method Grid\Column|Collection show_name(string $label = null)
     * @method Grid\Column|Collection shop_name(string $label = null)
     * @method Grid\Column|Collection shop_price(string $label = null)
     * @method Grid\Column|Collection shop_type(string $label = null)
     * @method Grid\Column|Collection shop_par(string $label = null)
     * @method Grid\Column|Collection shop_discount(string $label = null)
     * @method Grid\Column|Collection shop_msg(string $label = null)
     * @method Grid\Column|Collection shop_pic(string $label = null)
     * @method Grid\Column|Collection href(string $label = null)
     * @method Grid\Column|Collection target(string $label = null)
     * @method Grid\Column|Collection sort(string $label = null)
     * @method Grid\Column|Collection remark(string $label = null)
     * @method Grid\Column|Collection create_at(string $label = null)
     * @method Grid\Column|Collection update_at(string $label = null)
     * @method Grid\Column|Collection delete_at(string $label = null)
     * @method Grid\Column|Collection sequence(string $label = null)
     * @method Grid\Column|Collection batch_id(string $label = null)
     * @method Grid\Column|Collection family_hash(string $label = null)
     * @method Grid\Column|Collection should_display_on_index(string $label = null)
     * @method Grid\Column|Collection content(string $label = null)
     * @method Grid\Column|Collection entry_uuid(string $label = null)
     * @method Grid\Column|Collection tag(string $label = null)
     * @method Grid\Column|Collection apikey(string $label = null)
     * @method Grid\Column|Collection email_verified_at(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection id
     * @property Show\Field|Collection name
     * @property Show\Field|Collection type
     * @property Show\Field|Collection version
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection value
     * @property Show\Field|Collection username
     * @property Show\Field|Collection password
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection pid
     * @property Show\Field|Collection uid
     * @property Show\Field|Collection before
     * @property Show\Field|Collection balance
     * @property Show\Field|Collection after
     * @property Show\Field|Collection aid
     * @property Show\Field|Collection orderid
     * @property Show\Field|Collection xftype
     * @property Show\Field|Collection deleted_at
     * @property Show\Field|Collection role
     * @property Show\Field|Collection power_par
     * @property Show\Field|Collection user
     * @property Show\Field|Collection pwd
     * @property Show\Field|Collection admin_url
     * @property Show\Field|Collection api_acco
     * @property Show\Field|Collection api_key
     * @property Show\Field|Collection api_url
     * @property Show\Field|Collection status
     * @property Show\Field|Collection desc
     * @property Show\Field|Collection discount
     * @property Show\Field|Collection amount
     * @property Show\Field|Collection aamount
     * @property Show\Field|Collection bamount
     * @property Show\Field|Collection uuid
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection province_name
     * @property Show\Field|Collection acco
     * @property Show\Field|Collection kk_amount
     * @property Show\Field|Collection msg
     * @property Show\Field|Collection p_order_id
     * @property Show\Field|Collection u_order_id
     * @property Show\Field|Collection order_price
     * @property Show\Field|Collection notify
     * @property Show\Field|Collection shop_id
     * @property Show\Field|Collection notify_status
     * @property Show\Field|Collection notify_msg
     * @property Show\Field|Collection province
     * @property Show\Field|Collection c_id
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection tokenable_type
     * @property Show\Field|Collection tokenable_id
     * @property Show\Field|Collection abilities
     * @property Show\Field|Collection last_used_at
     * @property Show\Field|Collection power_id
     * @property Show\Field|Collection show_name
     * @property Show\Field|Collection shop_name
     * @property Show\Field|Collection shop_price
     * @property Show\Field|Collection shop_type
     * @property Show\Field|Collection shop_par
     * @property Show\Field|Collection shop_discount
     * @property Show\Field|Collection shop_msg
     * @property Show\Field|Collection shop_pic
     * @property Show\Field|Collection href
     * @property Show\Field|Collection target
     * @property Show\Field|Collection sort
     * @property Show\Field|Collection remark
     * @property Show\Field|Collection create_at
     * @property Show\Field|Collection update_at
     * @property Show\Field|Collection delete_at
     * @property Show\Field|Collection sequence
     * @property Show\Field|Collection batch_id
     * @property Show\Field|Collection family_hash
     * @property Show\Field|Collection should_display_on_index
     * @property Show\Field|Collection content
     * @property Show\Field|Collection entry_uuid
     * @property Show\Field|Collection tag
     * @property Show\Field|Collection apikey
     * @property Show\Field|Collection email_verified_at
     *
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection pid(string $label = null)
     * @method Show\Field|Collection uid(string $label = null)
     * @method Show\Field|Collection before(string $label = null)
     * @method Show\Field|Collection balance(string $label = null)
     * @method Show\Field|Collection after(string $label = null)
     * @method Show\Field|Collection aid(string $label = null)
     * @method Show\Field|Collection orderid(string $label = null)
     * @method Show\Field|Collection xftype(string $label = null)
     * @method Show\Field|Collection deleted_at(string $label = null)
     * @method Show\Field|Collection role(string $label = null)
     * @method Show\Field|Collection power_par(string $label = null)
     * @method Show\Field|Collection user(string $label = null)
     * @method Show\Field|Collection pwd(string $label = null)
     * @method Show\Field|Collection admin_url(string $label = null)
     * @method Show\Field|Collection api_acco(string $label = null)
     * @method Show\Field|Collection api_key(string $label = null)
     * @method Show\Field|Collection api_url(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection desc(string $label = null)
     * @method Show\Field|Collection discount(string $label = null)
     * @method Show\Field|Collection amount(string $label = null)
     * @method Show\Field|Collection aamount(string $label = null)
     * @method Show\Field|Collection bamount(string $label = null)
     * @method Show\Field|Collection uuid(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection province_name(string $label = null)
     * @method Show\Field|Collection acco(string $label = null)
     * @method Show\Field|Collection kk_amount(string $label = null)
     * @method Show\Field|Collection msg(string $label = null)
     * @method Show\Field|Collection p_order_id(string $label = null)
     * @method Show\Field|Collection u_order_id(string $label = null)
     * @method Show\Field|Collection order_price(string $label = null)
     * @method Show\Field|Collection notify(string $label = null)
     * @method Show\Field|Collection shop_id(string $label = null)
     * @method Show\Field|Collection notify_status(string $label = null)
     * @method Show\Field|Collection notify_msg(string $label = null)
     * @method Show\Field|Collection province(string $label = null)
     * @method Show\Field|Collection c_id(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection tokenable_type(string $label = null)
     * @method Show\Field|Collection tokenable_id(string $label = null)
     * @method Show\Field|Collection abilities(string $label = null)
     * @method Show\Field|Collection last_used_at(string $label = null)
     * @method Show\Field|Collection power_id(string $label = null)
     * @method Show\Field|Collection show_name(string $label = null)
     * @method Show\Field|Collection shop_name(string $label = null)
     * @method Show\Field|Collection shop_price(string $label = null)
     * @method Show\Field|Collection shop_type(string $label = null)
     * @method Show\Field|Collection shop_par(string $label = null)
     * @method Show\Field|Collection shop_discount(string $label = null)
     * @method Show\Field|Collection shop_msg(string $label = null)
     * @method Show\Field|Collection shop_pic(string $label = null)
     * @method Show\Field|Collection href(string $label = null)
     * @method Show\Field|Collection target(string $label = null)
     * @method Show\Field|Collection sort(string $label = null)
     * @method Show\Field|Collection remark(string $label = null)
     * @method Show\Field|Collection create_at(string $label = null)
     * @method Show\Field|Collection update_at(string $label = null)
     * @method Show\Field|Collection delete_at(string $label = null)
     * @method Show\Field|Collection sequence(string $label = null)
     * @method Show\Field|Collection batch_id(string $label = null)
     * @method Show\Field|Collection family_hash(string $label = null)
     * @method Show\Field|Collection should_display_on_index(string $label = null)
     * @method Show\Field|Collection content(string $label = null)
     * @method Show\Field|Collection entry_uuid(string $label = null)
     * @method Show\Field|Collection tag(string $label = null)
     * @method Show\Field|Collection apikey(string $label = null)
     * @method Show\Field|Collection email_verified_at(string $label = null)
     */
    class Show {}

    /**
     
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
