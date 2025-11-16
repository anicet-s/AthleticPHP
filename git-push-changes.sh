#!/bin/bash

###############################################################################
# Git Push Script - Push refactored changes to remote repository
###############################################################################

echo "=========================================="
echo "Git Push - Athletic PHP Refactoring"
echo "=========================================="
echo ""

# Check if git user is configured
GIT_USER=$(git config user.name)
GIT_EMAIL=$(git config user.email)

if [ -z "$GIT_USER" ] || [ -z "$GIT_EMAIL" ]; then
    echo "⚠️  Git user identity not configured"
    echo ""
    echo "Please configure your git identity:"
    echo ""
    read -p "Enter your name: " USER_NAME
    read -p "Enter your email: " USER_EMAIL
    
    echo ""
    echo "Configuring git..."
    git config user.name "$USER_NAME"
    git config user.email "$USER_EMAIL"
    echo "✓ Git identity configured"
    echo ""
fi

echo "Git User: $(git config user.name)"
echo "Git Email: $(git config user.email)"
echo ""

# Check if changes are staged
if git diff --cached --quiet; then
    echo "⚠️  No changes staged for commit"
    echo ""
    echo "Staging all changes..."
    git add -A
    echo "✓ Changes staged"
    echo ""
fi

# Show what will be committed
echo "Files to be committed:"
git status --short | head -20
TOTAL_FILES=$(git status --short | wc -l)
echo "... and $TOTAL_FILES files total"
echo ""

# Verify .env is not included
if git status --short | grep -q "\.env$"; then
    echo "❌ ERROR: .env file is staged!"
    echo "This file contains sensitive information and should not be committed."
    echo "Run: git reset HEAD .env"
    exit 1
else
    echo "✓ .env file is properly ignored"
fi

echo ""
read -p "Do you want to commit these changes? (y/n): " CONFIRM

if [ "$CONFIRM" != "y" ] && [ "$CONFIRM" != "Y" ]; then
    echo "Commit cancelled"
    exit 0
fi

echo ""
echo "Creating commit..."

# Commit with detailed message
git commit -m "Refactor: Complete application modernization and security improvements

Major Changes:
- Implemented MVC architecture with proper separation of concerns
- Added routing system for clean URLs
- Fixed critical SQL injection vulnerabilities
- Moved database credentials to environment variables
- Added CSRF protection for all forms
- Implemented secure session handling

Security Fixes:
- Fixed SQL injection in all database queries
- Removed hardcoded credentials from source code
- Added input validation and sanitization
- Implemented proper error handling and logging
- Added security headers in .htaccess
- Fixed mixed content issues (HTTP to HTTPS)

Architecture:
- Created src/ directory with PSR-4 autoloading
- Implemented BaseController with reusable methods
- Created proper Models (Injury, Diagnostic)
- Added Router class for URL handling
- Moved assets to public/ directory

Configuration:
- Added Composer for dependency management
- Created .env.example for environment configuration
- Added PostgreSQL support
- Updated .gitignore to exclude sensitive files

Documentation:
- Added comprehensive installation guide
- Created migration guide from old version
- Added developer guide and security documentation
- Created quick reference and troubleshooting guides

Files Added:
- bootstrap.php - Application bootstrap
- public/index.php - New entry point
- public/router.php - Router for built-in server
- src/Config/Database.php - Database configuration
- src/Controllers/* - MVC controllers
- src/Models/* - Database models
- Multiple documentation files

Assets:
- Moved images/, style/, js/ to public/ directory
- Updated all views to use helper functions
- Fixed asset paths for proper loading"

if [ $? -eq 0 ]; then
    echo "✓ Commit created successfully"
    echo ""
else
    echo "❌ Commit failed"
    exit 1
fi

# Check if remote exists
if ! git remote | grep -q "origin"; then
    echo "⚠️  No remote repository configured"
    echo ""
    read -p "Enter remote repository URL: " REMOTE_URL
    git remote add origin "$REMOTE_URL"
    echo "✓ Remote added"
    echo ""
fi

# Get current branch
BRANCH=$(git branch --show-current)
echo "Current branch: $BRANCH"
echo ""

read -p "Push to remote repository? (y/n): " PUSH_CONFIRM

if [ "$PUSH_CONFIRM" != "y" ] && [ "$PUSH_CONFIRM" != "Y" ]; then
    echo "Push cancelled"
    echo "You can push later with: git push origin $BRANCH"
    exit 0
fi

echo ""
echo "Pushing to remote..."
git push origin "$BRANCH"

if [ $? -eq 0 ]; then
    echo ""
    echo "=========================================="
    echo "✓ Successfully pushed to remote!"
    echo "=========================================="
    echo ""
    echo "Summary:"
    echo "- Commit created with detailed message"
    echo "- Changes pushed to origin/$BRANCH"
    echo "- .env file properly excluded"
    echo ""
    echo "Next steps:"
    echo "1. Verify changes on remote repository"
    echo "2. Update .env on production server"
    echo "3. Run composer install on production"
    echo "4. Import database schema if needed"
else
    echo ""
    echo "❌ Push failed"
    echo "You may need to pull first: git pull origin $BRANCH"
    exit 1
fi
