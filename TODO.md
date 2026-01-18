📌 NESTLIFY – PROJECT TODO LIST

🧱 PHASE 1: CORE FUNCTIONALITY & CORRECTNESS (HIGH PRIORITY)

Goal: Make sure the system behaves correctly and no rules are violated.

🔐 Access Control & Visibility
[ ] Prevent public access to unapproved properties
[ ] Ensure only approved properties appear on:
Buyer listings
Property details pages
[ ] Restrict approve/reject actions to Admin only
[ ] Prevent agents from editing:
Approved properties
Rejected properties (optional decision)
[ ] Add fallback “Property not available” message for invalid access

🏠 Property Management Logic
[ ] Enforce property status values:
pending
approved
rejected
[ ] Automatically set new properties to pending
[ ] Ensure rejected properties never appear publicly
[ ] Add default ordering:
Approved → newest first
[ ] Prevent deletion of approved properties (optional rule)

🖼 Image Handling (Stability)
[ ] Enforce exactly 4 images on property creation
[ ] Preserve image click order for main image selection ✔️ (DONE)
[ ] Validate image size and type
[ ] Ensure first-clicked image is main display
[ ] Handle missing images gracefully

✅ Features System (Logic)
[ ] Finalise list of 5–6 core features (fixed set)
[ ] Ensure unchecked features show red ❌
[ ] Ensure checked features show green ✔
[ ] Validate features input before saving
[ ] Prevent feature mismatch between DB and UI

🎨 PHASE 2: USER EXPERIENCE & UI IMPROVEMENTS (MEDIUM PRIORITY)
Goal: Make the app pleasant, intuitive, and professional.

🧭 Navigation & Flow
[ ] Add breadcrumbs to property details page
[ ] Add “Back to listings” button
[ ] Improve empty states (no properties found)
[ ] Add loading states for Livewire actions
🏷 Property Display
[ ] Add status badge (Pending / Approved / Rejected)
[ ] Improve image gallery UI
[ ] Add price formatting helper
[ ] Add property summary card hover effects
[ ] Improve mobile responsiveness

🧑‍💼 Agent Experience
[ ] Show approval status on agent dashboard
[ ] Add “Awaiting approval” notice
[ ] Disable edit buttons visually for locked properties
[ ] Add property preview before submission

🔒 PHASE 3: SECURITY & STRUCTURE HARDENING (LATER)
Goal: Prepare the system for production use.

🔐 Authorization & Policies
[ ] Create Laravel Policies for:
Property view
Property edit
Property approval
[ ] Replace inline checks with policies
[ ] Add middleware for admin-only routes

🆔 URL & Identity Improvements
[ ] Replace numeric IDs with:
UUIDs or
Encoded hashes
[ ] Add property slugs:
/property/lekki-2-bedroom-apartment
[ ] Handle slug collisions
[ ] Redirect old URLs gracefully

📈 PHASE 4: PERFORMANCE & SCALABILITY (FUTURE)
Goal: Make the system fast and reliable under load.
[ ] Add database indexes (status, created_at)
[ ] Implement eager loading for relations
[ ] Cache approved property listings
[ ] Add pagination to listings
[ ] Optimize image loading (lazy load)

🧪 PHASE 5: TESTING & QUALITY CONTROL
Goal: Reduce bugs and improve confidence.
[ ] Feature tests for property approval flow
[ ] Test image upload logic
[ ] Test visibility rules (approved vs pending)
[ ] Manual testing checklist
[ ] Error logging and monitoring setup
🚀 PHASE 6: PRODUCTION READINESS (FINAL)
Goal: Launch-ready application.
[ ] Environment-based configs
[ ] Disable debug in production
[ ] Add basic analytics
[ ] SEO metadata for property pages
[ ] Deployment checklist
[ ] Backup strategy

📝 OPTIONAL DOCUMENTATION
[ ] README.md (setup + usage)
[ ] API documentation (if needed)
[ ] Admin usage guide
[ ] Agent onboarding guide