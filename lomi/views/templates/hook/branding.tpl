{*
* lomi. checkout branding card (pay-with image + payment icons)
*}
<div class="wc-lomi-checkout-branding">
	<div class="wc-lomi-checkout-branding__header">
		{if $lomi_pay_with_image_url}
			<span class="wc-lomi-checkout-branding__badge">
				<img class="wc-lomi-pay-with-image"
				     src="{$lomi_pay_with_image_url|escape:'html':'UTF-8'}"
				     alt="{l s='Pay with lomi.' d='Modules.Lomi.Shop'}"
				     loading="lazy"
				     decoding="async" />
			</span>
		{else}
			<p class="wc-lomi-checkout-branding__title">
				{l s='Pay with' d='Modules.Lomi.Shop'} <strong>lomi.</strong>
			</p>
		{/if}
	</div>
	{if $lomi_payment_icons|@count}
		<div class="wc-lomi-checkout-branding__methods">
			{foreach from=$lomi_payment_icons item=icon}
				<div class="wc-lomi-checkout-branding__method{if $icon.wide} wc-lomi-checkout-branding__method--wide{/if}">
					<img src="{$icon.url|escape:'html':'UTF-8'}" alt="" loading="lazy" decoding="async" />
				</div>
			{/foreach}
		</div>
	{/if}
</div>
