# 🧪 CONSULTATION FEATURE - TESTING GUIDE

## Prerequisites
- PHP 8.1+
- MySQL 8.0+ running
- Laravel 11
- Composer installed

---

## 🚀 Quick Setup (5 minutes)

### Step 1: Database Setup
```bash
# Create database
mysql -u root -p
> CREATE DATABASE skinquo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
> EXIT;

# Edit .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=skinquo
DB_USERNAME=root
DB_PASSWORD=your_password

# Run migrations
php artisan migrate --force
```

### Step 2: Clear Caches
```bash
php artisan config:clear
php artisan route:clear
php artisan cache:clear
```

### Step 3: Start Server
```bash
php artisan serve
# Server running at http://127.0.0.1:8000
```

---

## 📋 Test Cases

### TEST 1: Page Load
**URL**: http://localhost:8000/consultation

**Expected**:
- ✅ Page loads without errors
- ✅ Hero section visible with "LETS FIND YOUR RATIONAL SKIN ROUTINE"
- ✅ Textarea with placeholder text present
- ✅ Pills bar with + button visible
- ✅ Submit arrow button at bottom
- ✅ No JavaScript console errors

**Result**: PASS / FAIL

---

### TEST 2: Tag System
**Steps**:
1. Click the + button in pills bar
2. Click "Oily T-Zone" from suggestions
3. Click + again
4. Click "Dry Cheeks"
5. Hover over a pill tag
6. Click the × to remove it

**Expected**:
- ✅ Dropdown appears with suggestions
- ✅ Clicking suggestion adds pill to bar
- ✅ Pill displays with × remove button
- ✅ Hovering shows interactive state
- ✅ Clicking × removes pill
- ✅ Pills persist if form re-validates

**Result**: PASS / FAIL

---

### TEST 3: Form Submission (AJAX)
**Steps**:
1. Clear any existing text
2. Type: "My skin is oily in the T-zone but cheeks are dry and sensitive to vitamin C"
3. Add tags: "Oily T-Zone", "Dry Cheeks", "Sensitive"
4. Click submit arrow button

**Expected**:
- ✅ Button shows loading spinner
- ✅ Form fields disabled
- ✅ AJAX request sent to /consultation/analyze
- ✅ Modal appears after ~1 second
- ✅ Modal shows "STEP 2 OF 3" title
- ✅ Trait cards appear with animations
- ✅ Cards show: emoji, trait name, description

**Traits Should Include**:
- 💧 Oily T-Zone (Detected from text)
- 🌵 Dry Cheeks (Detected from text)
- ⚡ Sensitive (S3 Stinger) (High priority alert)
- 🔴 Redness (Detected from text) [if matched keywords]

**Result**: PASS / FAIL

---

### TEST 4: Modal Refinement Panel
**Steps**:
1. Modal is open from previous test
2. In "Refine Preferences" panel:
   - Select "Acne" from first dropdown
   - Select "Dark Spots" from second dropdown
   - Check "Vegan" checkbox
   - Check "Fragrance-Free" checkbox
3. Observe changes

**Expected**:
- ✅ Both dropdowns functional
- ✅ Selections persist
- ✅ Checkboxes can be checked/unchecked
- ✅ Checked items show checked state
- ✅ Multiple checkboxes can be selected

**Result**: PASS / FAIL

---

### TEST 5: Modal Confirmation
**Steps**:
1. With modal open and preferences selected
2. Click "Confirm & Continue" button
3. Observe form submission

**Expected**:
- ✅ Modal closes smoothly
- ✅ Form submits to POST /consultation
- ✅ Page loads result page (or shows loading indicator)
- ✅ URL changes to /consultation/{id}

**Result**: PASS / FAIL

---

### TEST 6: Result Page Display
**URL**: http://localhost:8000/consultation/{id}
(From previous test, should auto-redirect)

**Expected**:
- ✅ Hero section with "✨ Analisis Kulit Anda Selesai"
- ✅ Consultation ID displayed: #1, #2, etc
- ✅ Status badge showing "Pending"
- ✅ Result cards grid:
  - Detected Traits card with all traits listed
  - Top Concerns card with selected concerns
  - Your Preferences card with badges
  - Your Skin Story card with full text
- ✅ Action buttons:
  - "Explore Products →"
  - "Read Skin Guide"
  - "New Consultation"

**Result**: PASS / FAIL

---

### TEST 7: Database Verification
**Steps**:
1. Open MySQL client
2. Connect to skinquo database
3. Query: `SELECT * FROM consultations;`

**Expected**:
- ✅ One record exists
- ✅ Record contains:
  - id: 1
  - user_id: NULL (since not logged in)
  - skin_story: "My skin is oily..."
  - tags: ["Oily T-Zone", "Dry Cheeks", "Sensitive"]
  - detected_traits: ["Oily T-Zone", "Dry Cheeks", ...]
  - concern_1: "acne"
  - concern_2: "dark_spots"
  - preferences: ["vegan", "fragrance_free"]
  - recommendations: NULL
  - status: "pending"
  - created_at: current timestamp

**Result**: PASS / FAIL

---

### TEST 8: Error Handling - Empty Input
**Steps**:
1. Go to /consultation page
2. Leave textarea empty
3. Click submit arrow

**Expected**:
- ✅ Browser validation message appears
- ✅ Form doesn't submit
- ✅ User sees "This field is required"

**Result**: PASS / FAIL

---

### TEST 9: Error Handling - Server Response
**Steps**:
1. Open browser console
2. Type in textarea: "x" (only 1 character)
3. Click submit arrow
4. Check network tab

**Expected**:
- ✅ AJAX request fails with 422 status
- ✅ Error message returned: validation error
- ✅ User sees alert: "⚠️ [error message]"
- ✅ Form remains fillable for retry

**Result**: PASS / FAIL

---

### TEST 10: Mobile Responsiveness
**Steps**:
1. Open Chrome DevTools
2. Toggle Device Toolbar (Ctrl+Shift+M)
3. Test on iPhone SE (375px width)
4. Test on iPad (768px width)

**Expected on Mobile**:
- ✅ Hero section scales properly
- ✅ Typography remains readable
- ✅ Textarea accessible
- ✅ Pills bar wraps nicely
- ✅ Button accessible and clickable
- ✅ Modal displays correctly (single column)
- ✅ All inputs and buttons have sufficient touch targets (44px minimum)

**Expected on Tablet**:
- ✅ Layout optimized for width
- ✅ Modal shows 2 columns (if space allows)
- ✅ Cards display properly

**Result**: PASS / FAIL

---

### TEST 11: Keyboard Navigation
**Steps**:
1. Open consultation page
2. Press TAB multiple times
3. Navigate through all form elements
4. While modal open, press ESC

**Expected**:
- ✅ Focus outline visible on all focusable elements
- ✅ TAB order logical: textarea → + button → submit arrow
- ✅ Can submit form with ENTER key
- ✅ Modal closes when ESC pressed
- ✅ No keyboard traps

**Result**: PASS / FAIL

---

### TEST 12: Form Re-submission
**Steps**:
1. Submit form and reach result page
2. Go back to /consultation
3. Browser should restore old form data

**Expected**:
- ✅ Textarea still contains previous skin_story
- ✅ Pills still visible with previous tags
- ✅ Browser's back button works

**Result**: PASS / FAIL

---

### TEST 13: Multiple Consultations
**Steps**:
1. Complete entire flow once
2. Go to /consultation again
3. Submit with DIFFERENT data:
   - Textarea: "My skin is very dry and dull"
   - Tags: "Dry Cheeks", "Dull Skin"
   - Concerns: "fine_lines", "dehydration"
   - Preferences: "cruelty_free" only

**Expected**:
- ✅ New consultation saved with ID #2
- ✅ Result page shows consultation #2
- ✅ First consultation still exists in database

**Result**: PASS / FAIL

---

### TEST 14: Admin Verification (Database)
**Steps**:
1. Query database:
```sql
SELECT id, skin_story, detected_traits, concern_1, concern_2, status, created_at 
FROM consultations 
ORDER BY created_at DESC;
```

**Expected**:
- ✅ Both consultations appear
- ✅ Data matches what was submitted
- ✅ Timestamps are in order
- ✅ Status all "pending"

**Result**: PASS / FAIL

---

## 🔍 Browser Console Tests

### Test 15: AJAX Request Inspection
**Steps**:
1. Open Console tab
2. Go to /consultation
3. Fill form and submit
4. Go to Network tab
5. Find POST request to /consultation/analyze

**Expected in Network**:
- ✅ Request shows:
  - URL: http://localhost:8000/consultation/analyze
  - Method: POST
  - Status: 200
  - Content-Type: application/json
- ✅ Request Payload shows:
  - skin_story: "..."
  - tags: "[...]"
- ✅ Response shows:
  - success: true
  - traits: [...]

**Result**: PASS / FAIL

---

### Test 16: Console Errors Check
**Steps**:
1. Complete entire consultation flow
2. Check Console tab for any errors

**Expected**:
- ✅ No JavaScript errors
- ✅ No 404 errors
- ✅ No CORS errors
- ✅ No deprecation warnings (minor warnings acceptable)

**Result**: PASS / FAIL

---

## 📊 Performance Tests

### TEST 17: Page Load Time
**Measure**:
- Time to /consultation page to fully load
- Time to AJAX response

**Expected**:
- ✅ /consultation loads in < 500ms
- ✅ AJAX analyze response in < 1000ms
- ✅ Result page loads in < 500ms

**Result**: _____ ms

---

### TEST 18: Database Query Count
**Steps**:
1. Enable Laravel Query Log
2. Access /consultation result page
3. Check how many queries executed

**Expected**:
- ✅ Exactly 1 SELECT query (get consultation)
- ✅ No N+1 queries
- ✅ No unnecessary joins

**Result**: _____ queries

---

## ✅ TEST SUMMARY

| Test # | Description | Status | Notes |
|--------|-------------|--------|-------|
| 1 | Page Load | | |
| 2 | Tag System | | |
| 3 | Form Submission (AJAX) | | |
| 4 | Modal Refinement | | |
| 5 | Modal Confirmation | | |
| 6 | Result Page Display | | |
| 7 | Database Verification | | |
| 8 | Error - Empty Input | | |
| 9 | Error - Server Response | | |
| 10 | Mobile Responsive | | |
| 11 | Keyboard Navigation | | |
| 12 | Form Re-submission | | |
| 13 | Multiple Consultations | | |
| 14 | Admin DB Verification | | |
| 15 | AJAX Inspection | | |
| 16 | Console Errors | | |
| 17 | Page Load Time | | |
| 18 | Query Count | | |

**Total Passed**: ___ / 18  
**Total Failed**: ___ / 18  

---

## 🐛 Bug Report Template

If you find issues, please document:

```
# Bug Report

## Title
[Brief description]

## Steps to Reproduce
1. 
2. 
3. 

## Expected Result
[What should happen]

## Actual Result
[What actually happened]

## Environment
- Browser: [Chrome/Firefox/Safari/Edge]
- OS: [Windows/Mac/Linux]
- Device: [Desktop/Mobile/Tablet]
- Screen Size: [1920x1080]

## Screenshots
[Attach if possible]

## Console Errors
[Paste any JavaScript errors]

## Database Query
[If DB-related, show the query]

## Severity
[ ] Critical (app broken)
[ ] High (major feature broken)
[ ] Medium (feature partially works)
[ ] Low (minor cosmetic issue)
```

---

## 📞 Support

For questions or issues:
1. Check CONSULTATION_REFACTOR_COMPLETE.md for details
2. Check browser console for errors
3. Check MySQL for data
4. Review this testing guide

---

**Testing Date**: _____________  
**Tester Name**: _____________  
**Overall Status**: ✅ READY / ❌ NEEDS FIXES

Generated: 2025-04-10
