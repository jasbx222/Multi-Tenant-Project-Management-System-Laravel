Summary
This repository contains a Multi-Tenant Project and Company Management System built with Laravel. It allows multiple companies to exist within a single application, with users having distinct roles (Owner, Manager, Member) within each company. The system provides granular access control for managing companies and projects, ensuring data segregation and appropriate permissions.

The main problem this project solves is the complexity of managing multiple distinct entities (companies) and their associated resources (projects) within a single application while enforcing strict user roles and permissions.

Key features include:

Multi-Tenancy: Isolates data and functionality for different companies.
Role-Based Access Control: Differentiates user permissions (Owner, Manager, Member) within each company, going beyond simple admin/user distinctions.
Company and Project Management: Robust CRUD operations for managing companies and their projects.
API-First Design: Ready-to-use API endpoints for integration with frontend applications (e.g., React, Flutter).
Authentication: Leverages Laravel Sanctum for secure API token-based authentication.
This system is targeted towards organizations that need to manage projects for multiple clients or departments independently, where users may belong to several of these entities and require specific access levels for each. It's also suitable for SaaS providers offering project management tools to their own clients.
