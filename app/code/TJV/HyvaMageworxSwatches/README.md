# TJV_HyvaMageworxSwatches

Hyvä-theme compatibility layer for **MageWorx Advanced Products Options — Option Swatches**.

MageWorx's own frontend rendering (RequireJS/jQuery/Knockout, DOM-injected via
`Options\Type\Select::getValuesHtml()`) is built for Luma and does not run under
Hyvä (no RequireJS on the frontend). This module disables MageWorx's frontend
output and replaces it with native Hyvä/Alpine.js templates that reuse
MageWorx's existing **admin, data, and pricing** layer untouched.

Nothing in MageWorx's admin UI, database columns, or backend logic is modified.
Only the *storefront rendering* is replaced.

---

## What this module does

1. Disables MageWorx's Luma-era frontend blocks/containers on the product page
   (`OptionBase`, `OptionSwatches`, `OptionFeatures`, `OptionAdvancedPricing`,
   `OptionDependency`, `OptionInventory`, `DynamicOptionsBase`) via layout XML
   `remove="true"` overrides, one per module (layout merge is scoped per
   module, so each needs its own file).
2. Disables the `mageworx_optionbase_around_options_html` plugin
   (`MageWorx\OptionBase\Plugin\AroundOptionsHtml`), which wraps every
   option's HTML in a `DOMDocument` — this is incompatible with PHP 8.2+
   deprecation handling (`Laminas\Stdlib\StringWrapper\MbString::convert()`)
   and fatals on every render under strict error handling.
3. Provides a `MageworxSwatch` ViewModel that exposes MageWorx's existing
   swatch data (is_swatch flag, swatch image/color, dimensions, show
   title/price config, tax-aware pricing) to Hyvä templates.
4. Overrides three core Hyvä/Magento_Catalog templates to render swatches
   (image, color, or text tiles) for Drop-down, Multiple Select, Radio, and
   Checkbox option types, using Alpine.js instead of jQuery/Knockout:
   - `product/view/options/type/select.phtml` — option wrapper + label,
     owns the shared Alpine state for swatch options.
   - `product/composite/fieldset/options/view/multiple.phtml` — Drop-down /
     Multiple Select swatch tiles.
   - `product/composite/fieldset/options/view/checkable.phtml` — Radio /
     Checkbox swatch tiles (uses native `peer-checked` CSS, no Alpine state
     needed).

Price is unaffected — this reuses Magento/MageWorx's native custom-option
pricing (`CustomOptionPrice`, `AdvancedPricingPrice`), so per-value pricing,
tax display mode, and cart totals all work exactly as they did before.

---

## Requirements

- MageWorx Advanced Products Options with Option Swatches, **licensed and
  already installed** (`app/code/MageWorx/*`).
- Hyvä theme (`hyva-themes/magento2-theme-module`) with a child theme.
- PHP 8.2+ (the `AroundOptionsHtml` disable specifically targets a PHP
  8.2+ deprecation-handling incompatibility, but the swatch rendering itself
  works on any Hyvä-supported PHP version).

---

## File map

```
app/code/TJV/HyvaMageworxSwatches/
├── registration.php
├── etc/
│   ├── module.xml
│   └── frontend/
│       └── di.xml                          # disables AroundOptionsHtml plugin
└── ViewModel/
    └── MageworxSwatch.php                   # swatch data + price formatting

app/design/frontend/<Vendor>/<theme>/
├── MageWorx_OptionBase/layout/catalog_product_view.xml
├── MageWorx_OptionSwatches/layout/catalog_product_view.xml
├── MageWorx_OptionFeatures/layout/catalog_product_view.xml
├── MageWorx_OptionAdvancedPricing/layout/catalog_product_view.xml
├── MageWorx_OptionDependency/layout/catalog_product_view.xml
├── MageWorx_OptionInventory/layout/catalog_product_view.xml
├── MageWorx_DynamicOptionsBase/layout/catalog_product_view.xml
└── Magento_Catalog/templates/product/
    ├── view/options/type/select.phtml
    └── composite/fieldset/options/view/
        ├── multiple.phtml
        └── checkable.phtml
```

> Each `MageWorx_*` layout file removes only that module's own block/container
> (e.g. `mageworx.option.base`, `mageworx.option.swatches`). Layout XML merges
> per declaring module, so a single combined file will not work — every
> module that injects a block into `catalog_product_view` needs its own
> override file with a matching module folder name.

---

## How a swatch option renders

For an option with **Is Swatch = Yes** and type Drop-down / Multiple /
Radio / Checkbox:

- `select.phtml` builds one Alpine `x-data` scope per option, containing
  `selectedValues`, a precomputed `options` array (id/title/formatted
  price), and a `toggle(value)` method. This scope is shared by the label,
  the native `<select>`/inputs, and the swatch tiles below them.
- The native `<select>` / radio / checkbox inputs are kept in the DOM
  (visually hidden for Drop-down/Multiple via `sr-only`, or visually hidden
  behind the swatch tile via `peer` for Radio/Checkbox) so Hyvä's existing
  `updateCustomOptionValue()` price-recalculation and required-field
  validation keep working unmodified.
- Swatch tiles are plain buttons/labels; clicking one updates
  `selectedValues`, syncs the real form control, and dispatches a native
  `change` event — this is what triggers Hyvä's price update, exactly like
  a manual `<select>` change would.
- The option label shows the selected value's title and price inline
  (e.g. `Buttons * Golden (€43.00)`), driven by the same Alpine scope.

Non-swatch options (Is Swatch unchecked) fall through to Hyvä's original
markup unchanged — the `$isSwatch` check gates every custom addition.

---

## Known constraints / things to re-check after a MageWorx or Hyvä upgrade

- The plugin name `mageworx_optionbase_around_options_html` in
  `etc/frontend/di.xml` must match MageWorx's registered name exactly. If a
  MageWorx update renames or removes this plugin, the `disabled="true"`
  override becomes a no-op (harmless) or unnecessary (also harmless) — but
  re-check `app/code/MageWorx/OptionBase/etc/di.xml` after any MageWorx
  version bump.
- If Hyvä updates `Hyva\Theme\ViewModel\CustomOption::getOptionHtml()` or the
  core `multiple.phtml` / `checkable.phtml` / `select.phtml` structure
  changes upstream, re-diff our overrides against the new Hyvä version.
- `MageworxSwatch::formatPrice()` uses
  `PricingHelper::currencyByStore($price, $store, false)` (no HTML
  container) to keep prices safe to embed inside Alpine `x-data` JSON.
  Don't reintroduce the HTML-wrapped variant here — it will break attribute
  parsing.
- The cart configure page (`checkout/cart/configure/...`) reuses this same
  block/template chain, so no separate handling is needed there.
