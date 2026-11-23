# Products

All products use one post type, `cfspas_product`. Three taxonomies organize them:

| Taxonomy | Purpose | Examples (from cfspas.com) |
| --- | --- | --- |
| `cfspas_product_type` | What the product is. Its slug decides which specification fields appear. | `hot-tubs`, `swim-spas`, `saunas`, `cold-plunges`, `massage-chairs`, `pre-owned-spas` |
| `cfspas_product_brand` | Manufacturer or product line. Each brand has a logo and a default availability note. | `jacuzzi-hot-tubs`, `caldera-spas`, `finnleo-saunas`, `endless-pools` |
| `cfspas_product_collection` | Series or collection. Used on cards and for "Browse the …" related products. | `j-300-collection`, `utopia-series`, `hallmark-series` |

If the Type taxonomy is empty, the theme creates the six default type terms the first time it runs. The type slugs have to match the defaults: the ACF specification groups and `sp_get_default_product_types()` look them up by slug. A child type, for example "Infrared Saunas" under "Saunas", inherits its parent's specification fields. Assign the parent term as well so ACF shows the parent's fields in the editor.

**Product Features** (`cfspas_feature`) are a separate post type, listed under Products → Features. Each one has a title, a description and a featured image, for example "FreshWater® IQ System". You pick a product's features with the **Features** and **Optional Features** relationship fields.

## Where products appear

### Single product page: `single-cfspas_product.php`

The sections follow the original Elementor layout. A section is skipped when its data is empty.

1. **Intro.** Front-view image (or a gallery), brand logo, model year, title, price or pre-owned pricing, availability note, and Request Pricing and Financing buttons.
2. **Specifications.** Fields depend on the product type (see below), plus any "Additional Specifications" rows. Also shows a disclaimer, a brochure button and the top-view image.
3. **Call to action band.** "Find the Right Hot Tub for Your Lifestyle".
4. **3D viewer.** Only when a shortcode or embed is entered.
5. **About.** The post content, with an optional image.
6. **Video.** Same video fields as the page sections.
7. **Per-product page sections.** The Page Sections flexible content field is also available on products, for content like the SmartTub® promo.
8. **Features and Optional Features.**
9. **Browse the [Collection].** Other products of the same type in the same collection. Products without a collection use their brand instead.
10. **Pricing request form** (`#form`) and the **pricing disclaimer**.

Site-wide text for these sections lives under **Site-Wide → Product Page Options**: button labels, the financing page, the call to action, the form, and both disclaimers.

### Product grids

The same renderer, `sp_render_product_grid()`, drives three things:

- the **`[products]` shortcode**
- the **Product Grid** page section
- the related-products grid on single product pages

Card: brand logo, front image, title, collection (or brand), short details, and a "View Details" button.

| Type | Card details |
| --- | --- |
| Hot tubs, swim spas, pre-owned spas | Seats, jets, seating type (and sale price for pre-owned) |
| Saunas | Seats, sauna type |
| Massage chairs | Upright dimensions, weight |
| Cold plunges | Temperature |

#### `[products]` shortcode

| Attribute | Default | Notes |
| --- | --- | --- |
| `type` | | Type slug(s) or ID(s), comma separated |
| `brand` | | Brand slug(s) or ID(s) |
| `collection` | | Collection slug(s) or ID(s) |
| `relation` | `AND` | How `type`/`brand`/`collection` combine: `AND` or `OR` |
| `ids` | | Specific product IDs, displayed in that order |
| `exclude` | | Product IDs to leave out |
| `exclude_current` | `false` | Leave out the product being viewed |
| `limit` | `-1` | Number of products (`-1` = all) |
| `orderby` | `menu_order` | `menu_order`, `title`, `date`, `modified`, `rand`, `post__in` |
| `order` | | `ASC` / `DESC` |
| `columns` | `3` | 1–6 |
| `filter_by` | | Adds filter tabs: `collection`, `brand` or `type` |
| `button_text` | `View Details` | |
| `show_details` | `true` | |
| `show_logo` | `true` | |
| `class` | | Extra CSS class |
| `empty_message` | | Shown when nothing matches (otherwise nothing is output) |

To control ordering, set each product's **Order** (Page Attributes box). Grids sort by it, then by title.

Shortcode equivalents of the grids on cfspas.com:

| Page on cfspas.com | Shortcode |
| --- | --- |
| Home: Featured Hot Tubs | `[products type="hot-tubs" ids="…" columns="3"]` |
| Home: Featured Swim Spas | `[products type="swim-spas" ids="…" columns="3"]` |
| /shop-hot-tubs/: Our Best-Sellers | `[products type="hot-tubs" ids="…" columns="4"]` |
| /jacuzzi-hot-tubs/ | `[products type="hot-tubs" brand="jacuzzi-hot-tubs"]` |
| /jacuzzi-hot-tubs/: Sun & Soul | `[products type="hot-tubs" brand="sun-soul-spas" columns="2"]` |
| /brands/caldera-spas/ | `[products type="hot-tubs" brand="caldera-spas" filter_by="collection"]` |
| /endless-pools/ | `[products type="swim-spas" brand="endless-pools"]` |
| /finnleo-saunas/ | `[products type="saunas" brand="finnleo-saunas" filter_by="collection"]` |
| /jacuzzi-infrared-saunas/ | `[products type="saunas" brand="jacuzzi-infrared-saunas"]` |
| /brands/jacuzzi-massage-chairs/ | `[products type="massage-chairs" columns="4" button_text="View Details + Price"]` |
| /brands/kodiak-cold-plunge/ | `[products type="cold-plunges" brand="kodiak-cold-plunge" columns="1"]` |

PHP templates can call `echo sp_render_product_grid( array( 'type' => 'hot-tubs', 'columns' => 4 ) );`.

## Fields

| Field group (`acf-json/`) | Shown on |
| --- | --- |
| Product Details | All products. Tabs: Overview, Images, Buttons & Availability, Media, Features, More |
| Specifications: Hot Tubs, Swim Spas & Pre-Owned Spas | Type `hot-tubs`, `swim-spas`, `pre-owned-spas` |
| Specifications: Saunas | Type `saunas` |
| Specifications: Cold Plunges | Type `cold-plunges` |
| Specifications: Massage Chairs | Type `massage-chairs` |
| Pre-Owned Spa Details | Type `pre-owned-spas` (color, year, warranty, MSRP, prices, monthly payment) |
| Product Brand Options | Brand terms: logo, default availability note and link |
| Product Type Options | Type terms: singular name ("Hot Tub") used in headings |
| Product Page Options | Site-Wide options page |

The specification groups appear once a Type is checked. In the classic editor, ACF loads them as soon as the box is ticked.

Product images can be uploaded, or given as an external URL. The original site loads most product renders from the manufacturers' CDN. Card and page images use, in order: the uploaded image, then the image URL, then the featured image.

Specification labels and display formats live in `sp_get_product_spec_definitions()` in `functions/products.php`. They can be changed through the `sp_product_spec_definitions` filter.

## Migrating from cfspas.com

The original site stores product data in JetEngine meta fields, which its REST API does not expose. A migration therefore needs a database export, or WP-CLI on the live site, to read the meta keys. The mapping is:

| Old post type (JetEngine) | New |
| --- | --- |
| `hot-tubs`, `swim-spas`, `saunas`, `cold-plunges`, `massage-chairs`, `pre-owned-spas` | `cfspas_product` + matching Type term |
| `brands` / `collections` taxonomies | `cfspas_product_brand` / `cfspas_product_collection` (same slugs) |
| `features` | `cfspas_feature`, linked through each product's Features / Optional Features fields |
| `documents` | `cfspas_document` (already exists) |
