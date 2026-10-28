# SYSTEM CONTEXT FOR ANTIGRAVITY AI

## 1\. Project Overview

System Name: Sistem Informasi PPDB Online Mandiri Target Audience: Sekolah Swasta & Madrasah Aliyah (MA) Core Focus: Zero-Friction UX (Gaptek Friendly), Kurikulum Merdeka, Independent Financial System (No 3rd party payment gateway/admin fees), No WhatsApp requirement in initial phase.

## 2\. Tech Stack & Environment

- **Framework:** Laravel 10.x / 11.x (PHP 8.2)  
- **Environment:** Docker Compose (NGINX 1.24, MySQL 8.0, Redis Alpine)  
- **Frontend Stack:** Blade Templates \+ Tailwind CSS \+ Alpine.js (Lightweight & Reactive)  
- **PDF Generation:** `barryvdh/laravel-dompdf`  
- **QR Code Generator:** `simplesoftwareio/simple-qrcode`

## 3\. Key Business Rules & Workflows

### Authentication

- Applicants log in using **NIK (16 Digits) \+ Date of Birth (DDMMYYYY)** or **Registration Code (`PPDB-YYYY-XXXX`)**.  
- No password creation or email verification required for applicants.  
- Role-Based Access Control (RBAC) for admins: `admin`, `verifikator`, `bendahara`, `penguji`.

### Registration & Kurikulum Merdeka

- Step 1: Quick registration (\< 1 min) asking for Full Name, NIK, Phone Number, Wave selection. Generates Registration Code.  
- Step 2: Kurikulum Merdeka Cluster Selection (Keagamaan, MIPA/STEM, Soshum, Vokasi) & Boarding Preference (Mukim vs Non-Mukim).  
- Step 3: Parents/Wali Data & Sibling Auto-Check (input active sibling NISN for automatic discount).  
- Step 4: Direct Camera Photo Uploads for Documents (KK, Akta, SKL/Ijazah).

### Self-Hosted Financial System (No Fee / No 3rd Party)

- Direct bank transfer with exact amount (no admin fee).  
- Require fields upon upload proof: Sender Bank Name & Sender Account Owner Name.  
- Cashier Mode (Offline Cash Payment): Cashier can search applicant by NIK/RegCode and mark as PAID manually.  
- Auto-generate PDF Receipt with Digital Stamp and Verification QR Code.

### Panitia Dashboard Features

- **In-App Document Preview:** In-line image/PDF viewer without triggering browser file downloads.  
- **Diagnostic Assessment Entry:** Input BTQ (Baca Tulis Al-Qur'an), Tahfidz juz count, and Literacy/Numeracy scores (for class placement, not elimination).  
- **One-Click Export:** Export passed applicants into Excel formatted specifically for EMIS (Kemenag) and Dapodik (Kemendikbud).

## 4\. Storage & Security

- File uploads: JPG, PNG, PDF (Max 2MB per file).  
- Naming convention: SHA-256 random hash (`hash_filename.ext`).  
- Protection against CSRF, XSS, and API Rate Limiting (60 requests/minute).