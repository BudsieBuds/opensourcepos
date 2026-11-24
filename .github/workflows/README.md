# GitHub Actions

This document describes the CI/CD workflows for OSPOS.

## Build Docker & Release Assets Workflow (`.github/workflows/build-release.yml`)

### Build Process
- Setup PHP 8.2 with required extensions
- Setup Node.js 22
- Install composer dependencies
- Install npm dependencies
- Build frontend assets with Gulp

### Docker Images
- Build and push `opensourcepos` Docker image to Docker Hub
- On `master`: tagged `master` and `<sha>` (fast `linux/amd64` build)
- On other branches: tagged `<normalized-branch>-<sha>` (fast `linux/amd64` build). Slashes and non-alphanumeric characters (outside `[A-Za-z0-9_.-]`) are replaced with `_`, leading `-` or `.` are replaced with `_`, and tag length is capped at 128 characters (e.g. `feature/login` becomes `feature_login-<sha>`).
- On a semver tag (e.g. `3.4.2`): tagged `<version>` and `latest` (multi-arch `linux/amd64`, `linux/arm64`)
- The version number is never stamped onto `master`/branch builds — it only appears on tag releases

### Releases
- Create distribution archive (zip)
- Create/update GitHub "unstable" release on master branch only

## Required Secrets

> [!NOTE]
> Workflows in `build-release.yml` and staging deployment run only for the canonical `opensourcepos/opensourcepos` repository by default (`if: github.repository == 'opensourcepos/opensourcepos'`). To execute builds in a fork, you must intentionally update this repository guard to match your fork.

To use this workflow, you need to add the following secrets to your repository:

1. **DOCKER_USERNAME** - Docker Hub username for pushing images
2. **DOCKER_PASSWORD** - Docker Hub password/token for pushing images

### How to add secrets

1. Go to your repository on GitHub
2. Click **Settings** → **Secrets and variables** → **Actions**
3. Click **New repository secret**
4. Add `DOCKER_USERNAME` and `DOCKER_PASSWORD`

The `GITHUB_TOKEN` is automatically provided by GitHub Actions.

## Workflow Triggers

- **Push to master** - Runs build, Docker push (`master` + `<sha>` tags, `linux/amd64`), and creates/updates the `unstable` release
- **Push to other branches** - Runs build and Docker push (`<normalized-branch>-<sha>` tag, e.g. `feature_login-<sha>`, `linux/amd64`)
- **Push a semver tag** (e.g. `3.4.2`) - Runs build and multi-arch Docker push (`<version>` + `latest` tags, `linux/amd64` and `linux/arm64`)
- **Pull requests** - Runs build only for fork PRs (internal PRs build via branch push; tests run in parallel via phpunit.yml); no Docker push

## Existing Workflows

This repository also has these workflows:
- `.github/workflows/coding-standards.yml` (`Coding Standards (PHP-CS-Fixer)`) - PHP PSR-12 coding standards on changed files
- `.github/workflows/phpunit.yml` (`PHPUnit Tests`) - Unit and integration tests (PHP 8.2–8.5 across 6 database engines)
- `.github/workflows/php-linter.yml` (`PHP Syntax Linter`) - PHP syntax checks (PHP 8.2–8.5)
- `.github/workflows/install-script-test.yml` (`Ubuntu Install Script Test`) - Automated testing for `tools/scripts/install-ubuntu.sh`
- `.github/workflows/release.yml` (`Cut Official Release`) - Unified release cycle (git-cliff changelog, tagging, and version bumping)
- `.github/workflows/deploy.yml` (`Deploy to Staging (Manual)`) / `deploy-pr.yml` (`Deploy PR to Staging`) / `deploy-core.yml` (`Deploy Core (Reusable)`) - Staging deployment workflows

## Testing

PHPUnit tests are run separately via `.github/workflows/phpunit.yml` on every push and pull request, testing against PHP 8.2, 8.3, 8.4, and 8.5.

To test the build workflow:
1. Add the required secrets
2. Push to master or create a PR
3. Monitor the Actions tab in GitHub
