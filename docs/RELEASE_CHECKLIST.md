# Release Checklist

## Pre-Release

- [ ] Confirm version constant in `mindgrid-request-system.php`.
- [ ] Confirm plugin header version.
- [ ] Confirm `CHANGELOG.md` contains the release entry.
- [ ] Run PHP syntax checks for all plugin PHP files.
- [ ] Run WordPress activation and deactivation checks.
- [ ] Confirm no out-of-scope features were added.

## Package

- [ ] Exclude development-only files and local tooling output.
- [ ] Include `includes/`, `assets/`, `docs/`, `languages/`, `README.md`, `CHANGELOG.md`, and `.gitignore`.
- [ ] Confirm no Composer or npm artifacts are required.

## Post-Release

- [ ] Tag release in Git after PM approval.
- [ ] Update roadmap status.
- [ ] Plan next sprint implementation scope.
