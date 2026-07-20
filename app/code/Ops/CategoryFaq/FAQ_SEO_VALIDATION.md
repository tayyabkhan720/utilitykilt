# FAQ SEO Validation Guide

This guide explains how to verify that your FAQ implementation is working correctly for SEO purposes.

## 1. Visual Inspection in Browser

### View Page Source
1. Navigate to a category page with FAQs enabled
2. Right-click → "View Page Source" (or press `Ctrl+U` / `Cmd+U`)
3. Search for `application/ld+json` or `FAQPage`
4. Verify the JSON-LD structured data is present and properly formatted

### What to Look For:
- ✅ `<script type="application/ld+json">` tag exists
- ✅ `@context` is `"https://schema.org"`
- ✅ `@type` is `"FAQPage"`
- ✅ `mainEntity` array contains question/answer objects
- ✅ Each question has `@type: "Question"` with `name` field
- ✅ Each answer has `@type: "Answer"` with `text` field

## 2. Google Rich Results Test

### Online Tool:
**URL:** https://search.google.com/test/rich-results

### Steps:
1. Enter your category page URL (or paste HTML source)
2. Click "Test URL" or "Test Code"
3. Check for:
   - ✅ "FAQPage" detected
   - ✅ No errors or warnings
   - ✅ Preview shows FAQ rich results

### What Success Looks Like:
- Green checkmark for FAQPage
- Preview showing expandable FAQ items
- No critical errors

## 3. Schema.org Validator

### Online Tool:
**URL:** https://validator.schema.org/

### Steps:
1. Enter your page URL
2. Or paste the JSON-LD code directly
3. Verify:
   - ✅ Valid Schema.org markup
   - ✅ FAQPage type recognized
   - ✅ All required properties present

## 4. Browser Developer Tools

### Chrome DevTools:
1. Open DevTools (`F12` or `Ctrl+Shift+I`)
2. Go to **Console** tab
3. Run: `document.querySelector('script[type="application/ld+json"]')`
4. Verify the script tag exists

### Network Tab:
1. Open DevTools → **Network** tab
2. Reload the page
3. Filter by "Doc" or "All"
4. Check the HTML response contains JSON-LD

## 5. Command Line Testing

### Using cURL:
```bash
# Get page HTML
curl -s "https://your-site.com/category-page.html" | grep -A 20 "application/ld+json"

# Extract and validate JSON
curl -s "https://your-site.com/category-page.html" | \
  grep -oP '(?<=<script type="application/ld\+json">).*?(?=</script>)' | \
  python3 -m json.tool
```

### Using wget:
```bash
wget -qO- "https://your-site.com/category-page.html" | grep "FAQPage"
```

## 6. Common Issues to Check

### ❌ Empty FAQ Array
**Problem:** `mainEntity` is an empty array `[]`
**Solution:** Ensure category has FAQ content and regex pattern matches

### ❌ Missing Questions/Answers
**Problem:** Some FAQ items missing from JSON-LD
**Solution:** Check regex pattern matches your HTML format:
- Expected: `<strong>Question</strong>Answer</p>`
- Verify FAQ content matches this pattern

### ❌ Invalid JSON
**Problem:** JSON syntax errors
**Solution:** 
- Check for unescaped quotes in questions/answers
- Verify `json_encode()` flags are correct
- Test JSON with: `json_decode()` to validate

### ❌ HTML in Answers
**Problem:** HTML tags in `text` field of answers
**Solution:** Already handled with `strip_tags()` - verify it's working

### ❌ Missing Context
**Problem:** `@context` missing or incorrect
**Solution:** Ensure it's exactly `"https://schema.org"`

## 7. Testing Checklist

- [ ] JSON-LD script tag appears in page source
- [ ] JSON is valid (no syntax errors)
- [ ] Google Rich Results Test passes
- [ ] Schema.org validator confirms valid markup
- [ ] All FAQ items appear in structured data
- [ ] Questions and answers are properly formatted
- [ ] No HTML tags in answer `text` fields
- [ ] FAQ section is visible on the page
- [ ] JSON-LD only appears when FAQs exist (not empty array)

## 8. Advanced Testing

### Extract JSON-LD Programmatically:
```javascript
// In browser console
const script = document.querySelector('script[type="application/ld+json"]');
if (script) {
  const data = JSON.parse(script.textContent);
  console.log('FAQ Count:', data.mainEntity.length);
  console.log('First Question:', data.mainEntity[0].name);
}
```

### Validate with PHP:
```php
// Test JSON encoding
$testJson = json_encode($faqJson, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
$decoded = json_decode($testJson, true);
if (json_last_error() === JSON_ERROR_NONE) {
    echo "Valid JSON";
} else {
    echo "Error: " . json_last_error_msg();
}
```

## 9. Monitoring in Google Search Console

1. Go to **Enhancements** → **FAQ**
2. Check for:
   - Pages with valid FAQ markup
   - Any errors or warnings
   - Rich result status

## 10. Quick Validation Script

Save this as `validate-faq-seo.php` in your Magento root:

```php
<?php
require 'app/bootstrap.php';
$bootstrap = \Magento\Framework\App\Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();

$categoryId = 2; // Change to your category ID
$category = $objectManager->create(\Magento\Catalog\Model\Category::class)->load($categoryId);

$faqContent = $category->getCategoryFaq();
$enableFaq = $category->getEnableFaq();

echo "Category: " . $category->getName() . "\n";
echo "FAQ Enabled: " . ($enableFaq ? "Yes" : "No") . "\n";
echo "FAQ Content: " . (empty($faqContent) ? "Empty" : "Present") . "\n";

if ($faqContent) {
    preg_match_all('/<strong>(.*?)<\/strong>(.*?)<\/p>/', $faqContent, $matches, PREG_SET_ORDER);
    echo "FAQ Items Found: " . count($matches) . "\n";
    
    foreach ($matches as $i => $faq) {
        $q = trim(strip_tags($faq[1]));
        $a = trim(strip_tags($faq[2]));
        echo "  Q" . ($i+1) . ": " . substr($q, 0, 50) . "...\n";
        echo "  A" . ($i+1) . ": " . substr($a, 0, 50) . "...\n";
    }
}
```

Run with: `php validate-faq-seo.php`

## Success Criteria

Your FAQ is SEO-ready when:
- ✅ Google Rich Results Test shows valid FAQPage
- ✅ JSON-LD appears in page source
- ✅ All FAQ items are in structured data
- ✅ No validation errors
- ✅ Questions and answers are clean (no HTML in text fields)

