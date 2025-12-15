Multi-Tenant Project & Company Management System
 وصف المشروع

هذا المشروع عبارة عن نظام إدارة شركات ومشاريع متعدد الشركات (Multi-Tenant)، حيث يمكن لكل شركة أن تحتوي على مشاريع متعددة، وكل مستخدم يمكن أن يكون عضوًا في أكثر من شركة بدور مختلف (Owner / Manager / Member).

النظام يضمن:

صلاحيات دقيقة حسب دور المستخدم داخل الشركة وليس مجرد Admin أو لا.

إدارة الشركات والمشاريع بطريقة مرنة.

واجهة API جاهزة للعمل مع تطبيقات Frontend مثل React أو Flutter.

الهيكلية الأساسية
1
 Models

User: يمثل المستخدم، يحتوي على Trait HasApiTokens لدعم Laravel Sanctum.

Company: يمثل الشركة، علاقة Many-to-Many مع المستخدمين عبر جدول company_user.

Project: يمثل مشروع ضمن شركة، مرتبط بـ Company و Users (لتحديد المهام).

 Pivot Table

company_user:

user_id → المستخدم

company_id → الشركة

role → دور المستخدم داخل الشركة (owner, manager, member)


Policies
CompanyPolicy

view → كل عضو بالشركة يمكنه مشاهدة الشركة

create → أي مستخدم يمكنه إنشاء شركة جديدة

update / delete → فقط Owner يمكنه تعديل أو حذف الشركة

ProjectPolicy

create → Owner و Manager يمكنهم إنشاء مشاريع داخل الشركة

update / delete → Owner و Manager يمكنهم تعديل أو حذف المشاريع

view → Member يشاهد فقط المهام المخصصة له، Owner و Manager يشاهدون كل المشاريع

 Services

CrudService → Service أساسي يحتوي على وظائف CRUD عامة (create, read, update, delete).

CompanyService → يدير شركات المستخدمين، يسمح بإنشاء الشركات، جلب المشاريع، حذف الشركات مع مشاريعها.

ProjectService → يدير المشاريع، مرتبط بالشركة، يسمح بإدارة المشاريع حسب صلاحيات المستخدم.

 Controllers

CompanyController

index → جلب الشركات للمستخدم الحالي

store → إنشاء شركة جديدة

show → عرض تفاصيل شركة

update → تعديل الشركة (حسب Owner)

destroy → حذف الشركة (حسب Owner)

ProjectController

index → جلب مشاريع الشركة حسب دور المستخدم

store → إنشاء مشروع (Owner/Manager)

show → عرض مشروع

update → تعديل مشروع (Owner/Manager)

destroy → حذف مشروع (Owner/Manager)

جميع العمليات محمية باستخدام Policies + Authorization لضمان Multi-Tenant و صلاحيات دقيقة لكل دور.

 Authentication

يستخدم Laravel Sanctum لإنشاء API Tokens لكل مستخدم.

Login/Register API endpoints جاهزة للعمل مع Frontend.

كل عملية محمية باستخدام Guard sanctum.

 Middlewares

auth:sanctum → حماية كل Routes الخاصة بـ API

Authorization يتم عبر Policies لكل Model (Company, Project).

 قواعد البيانات

users → جدول المستخدمين

companies → جدول الشركات

projects → جدول المشاريع

company_user → pivot table للعلاقة Many-to-Many + دور المستخدم

personal_access_tokens → جدول Laravel Sanctum لتخزين الـ API tokens

 Packages & Tools Used

Laravel 10+ → Framework الأساسي

Laravel Sanctum → إدارة API Tokens و Authentication

MySQL → قاعدة البيانات

PHP 8+

Postman → اختبار API endpoints

1 مثال على Authorization Workflow

عضو الشركة يحاول تعديل مشروع:

Controller يستدعي: $this->authorize('update', $project);

Policy ProjectPolicy تتحقق من الدور:

Owner / Manager → يسمح

Member → يمنع إلا إذا المشروع تابع له

النتيجة → JSON response: success / forbidden

1 تشغيل المشروع
# تثبيت الحزم
composer install

# نسخ ملف البيئة
cp .env.example .env

# إعداد قاعدة البيانات في .env

# تشغيل Migrations
php artisan migrate

# تشغيل السيرفر
php artisan serve
