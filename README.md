# Jisr AI (جسر)

### AI-Powered Education & Career Opportunity Matching Platform

**Backend:** Laravel 12 · **Frontend:** React 18 · **Database:** MySQL · **AI:** Google Gemini · **Status:** In Development

**Jisr** — Arabic for **"bridge"** — is an AI-powered platform designed to connect students and recent graduates with relevant **educational and career opportunities**.

The platform uses AI-powered CV analysis to extract a user's skills, education, and qualifications, then uses that profile to provide explainable and ranked opportunity matching.

> **Formerly known as Manhati (منحتي)**, the project originally focused on scholarship discovery and matching. The rebrand to **Jisr** reflects its expansion toward connecting the academic journey with future career opportunities.

---

## ✨ What It Does

### 🎓 Education Track

#### CV Upload & AI Analysis

Users can upload their CV as a PDF. Google Gemini analyzes the document and extracts relevant information such as:

- Skills
- Education
- Qualifications
- Academic background
- Relevant experience

The extracted information is then used to build the user's opportunity profile.

#### 🎯 Scholarship Matching

Jisr matches the user's profile against scholarship eligibility criteria and generates an explainable **0–100% match score**.

The matching system considers different types of criteria:

- Mandatory criteria
- Academic requirements
- Skills
- Qualifications
- Other eligibility conditions

Mandatory requirements can disqualify an opportunity, while other criteria contribute to the overall weighted score.

#### ✍️ Cover Letter Generation

The platform can generate a personalized cover letter based on the user's profile and the selected scholarship opportunity.

#### 📋 Application Tracking

Users can save opportunities, apply to them, and track their application status through their personal dashboard.

#### 🔔 Deadline Alerts

The platform supports email notifications for upcoming scholarship deadlines.

#### 🔄 Automated Scholarship Synchronization

Jisr includes an external API client and scheduled Laravel command:

```bash
php artisan scholarships:sync
```

This allows scholarship opportunities to be automatically retrieved and synchronized with the platform database, alongside manually curated entries.

---

## 💼 Career Track

The career side of Jisr is currently under development.

### 💼 Job Opportunity Matching

The same profile extracted from a user's CV will be used to match the user with relevant job opportunities and their requirements.

The goal is to reuse the same explainable matching approach across both scholarships and jobs.

### 📊 Skill-Gap Analysis

Instead of only showing whether a user qualifies for a position, Jisr will identify missing skills and qualifications required for a target role.

This is intended to help users understand what they need to improve for their desired career path.

### 📈 Unified Applications & Analytics

The planned career module will provide a unified dashboard where users can view their:

- Scholarship applications
- Job applications
- Saved opportunities
- Matching results
- Career-related insights

---

## 🛠 Platform Features

### 👤 User Management

- User authentication
- Academic profile management
- CV upload
- AI-powered profile extraction
- Personalized opportunity recommendations

### 🧑‍💼 Admin Dashboard

Administrators can manage:

- Scholarships
- Scholarship criteria
- Job opportunities
- Opportunity requirements
- Platform activity

---

## 🧠 AI & Matching

Jisr uses **Google Gemini** for CV analysis and information extraction.

The matching engine is designed to provide more transparency than a simple recommendation list by producing an explainable score based on the relationship between:

**User Profile → Opportunity Requirements → Matching Criteria → Final Score**

This allows users to understand not only *which* opportunities are recommended, but also *why* they match their profile.

---

## 🏗️ Technology Stack

| Layer               | Technology        |
| ------------------- | ----------------- |
| Frontend            | React 18          |
| Backend             | Laravel 12        |
| Backend Language    | PHP 8.3           |
| Database            | MySQL             |
| AI / CV Analysis    | Google Gemini API |
| Development         | VS Code           |
| UI/UX Design        | Figma             |
| API Testing         | Postman           |
| Database Management | MySQL Workbench   |
| Version Control     | Git & GitHub      |

---

## 📌 Project Status

The core scholarship-matching MVP is currently functional end-to-end.

### Completed

- ✅ Authentication
- ✅ Academic profile management
- ✅ CV upload
- ✅ AI-based CV analysis
- ✅ Skills and education extraction
- ✅ Scholarship matching engine
- ✅ Explainable matching scores
- ✅ Scholarship recommendation
- ✅ Cover letter generation
- ✅ Save / apply functionality
- ✅ Application status tracking
- ✅ Admin dashboard
- ✅ Scholarship database
- ✅ Scholarship API synchronization

### In Progress

- 🔄 Manhati → Jisr rebranding across the remaining views
- 🔄 Final application-tracking edge cases

### Planned

- ⏳ Job opportunities module
- ⏳ Skill-gap analysis
- ⏳ Unified scholarship & job applications
- ⏳ Career analytics

---

## 🗺️ Roadmap

### 1. Complete Current Milestone

- Finish remaining application-tracking edge cases
- Complete the Manhati → Jisr rebrand
- Finalize remaining dashboard and platform views

### 2. Job Opportunities Module

- Job opportunity data model
- Admin management for job postings
- Job requirements and criteria
- Matching against user profiles
- Skill-gap analysis
- Unified applications dashboard

### 3. Final Phase

- Regression testing
- Demo dataset
- Production configuration
- Final presentation
- Final project demonstration

---

## 🚀 Getting Started

### Prerequisites

Make sure you have the following installed:

- PHP 8.3+
- Composer
- Node.js & npm
- MySQL
- Git

### Clone the Repository

```bash
git clone https://github.com/Emanmohammedsh/minhati-ai-scholarship-platform.git

cd minhati-ai-scholarship-platform
```

### Backend Setup

Install PHP dependencies:

```bash
composer install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

Configure your database and API credentials inside `.env`.

Run the migrations:

```bash
php artisan migrate
```

Seed the database:

```bash
php artisan db:seed
```

### Frontend Setup

Install JavaScript dependencies:

```bash
npm install
```

Start the frontend development server:

```bash
npm run dev
```

### Run Laravel

Start the Laravel development server:

```bash
php artisan serve
```

The application will then be available through the local Laravel development server.

---

## 🔐 Environment Variables

The following environment variables may be required:

```env
GEMINI_API_KEY=
GEMINI_MODEL=
SCHOLARSHIP_API_KEY=
```

### `GEMINI_API_KEY`

Used for AI-powered CV analysis and information extraction.

### `GEMINI_MODEL`

Optional configuration for selecting the Gemini model.

### `SCHOLARSHIP_API_KEY`

Optional API key used for automated scholarship synchronization.

To synchronize scholarships:

```bash
php artisan scholarships:sync
```

---

## 📂 High-Level Architecture

The platform is built around the following flow:

```text
                    ┌──────────────────┐
                    │      User        │
                    └────────┬─────────┘
                             │
                             ▼
                    ┌──────────────────┐
                    │    CV Upload     │
                    └────────┬─────────┘
                             │
                             ▼
                    ┌──────────────────┐
                    │   Gemini AI      │
                    │   CV Analysis    │
                    └────────┬─────────┘
                             │
                             ▼
                    ┌──────────────────┐
                    │ User Profile &   │
                    │ Extracted Skills │
                    └────────┬─────────┘
                             │
                  ┌──────────┴──────────┐
                  ▼                     ▼
        ┌─────────────────┐   ┌─────────────────┐
        │   Scholarships  │   │  Job Opportunities │
        │     Matching    │   │    Matching       │
        └────────┬────────┘   └────────┬────────┘
                 │                     │
                 └──────────┬──────────┘
                            ▼
                   ┌──────────────────┐
                   │ Ranked &         │
                   │ Explainable      │
                   │ Opportunities    │
                   └──────────────────┘
```

---

## 👥 Contributors

Built by:

- **Eman Mohammed Shbeir**
- **Adla Hamdan Abu Mu'ailiq**
- **Khitam AlFaqawi**

### Supervisor

**Hamza Abu Jarad**

### Institution

**Taqat Academy**

---

## 📜 License

License information will be added before the final release.

---

## 🔗 Repository

**GitHub:**
https://github.com/Emanmohammedsh/minhati-ai-scholarship-platform

---

> **Jisr — جسر**
> Connecting education, skills, and future opportunities. 