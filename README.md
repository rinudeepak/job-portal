# 🧑‍💼 Job Portal – Skill-Based Hiring System

A PHP & MySQL based job portal that automates hiring using **resume analysis**, **GitHub skill mapping**, and **technical scoring**.

---

## 📌 Features Overview

### 3.1 User & Job Management
**Candidates**
- Signup & Login
- Upload resume (PDF)
- Add/view skills
- View jobs
- Apply for jobs

**Recruiters**
- Signup & Login
- Post job openings
- View applicants

---

### 3.2 Resume, GitHub & LinkedIn Skill Mapping
- Extract skills from uploaded resumes
- Fetch GitHub profile data:
  - Public repositories
  - Programming languages used
  - Activity level
- Map extracted skills with job-required skills

---

### 3.3 Technical Skill Score
A **technical skill score** is calculated using GitHub & resume data.

**Scoring Logic**
- More repositories → higher score
- More commits → higher score
- More programming languages → higher score
- Resume skill match → bonus score

---

### 3.4 Hiring Funnel Automation
Candidates automatically move through hiring stages based on skill score.

**Hiring Stages**
1. Applied  
2. Shortlisted  
3. Technical Checked  
4. HR Checked  
5. Selected  

**Automation Rule**
- Skill score determines current stage
- Status updates automatically after evaluation

---

## 🛠 Tech Stack
- **Backend:** PHP (Core PHP, MVC structure)
- **Database:** MySQL
- **Frontend:** HTML, CSS, Bootstrap
- **API:** GitHub REST API
- **Server:** XAMPP

---

## 📂 Database Tables
- users
- jobs
- applications
- resumes
- skills

---

## 🚀 How to Run the Project
1. Clone the repository
2. Import the database SQL file
3. Configure database credentials
4. Start Apache & MySQL (XAMPP)
5. Open the project in browser


