Deployment workflow

This repo contains a GitHub Actions workflow that packages and deploys the WordPress plugin located in `techforbs-components/` to your Hostinger account.

Where the workflow lives
- GitHub Actions workflows must live under `.github/workflows/` at the repository root to run. To keep the workflow scoped to the backend code, the workflow is configured to only trigger on pushes that touch `techforbs-components/**`.

How the workflow behaves
- Default behavior: manual `workflow_dispatch` (recommended) or auto-run on push to `main` that changes `techforbs-components/**`.
- Default `plugin_path`: `techforbs-components` (you can override via workflow inputs).
- `dry_run=true` will only list remote files and will NOT upload anything.
- When `dry_run=false`, the workflow will upload the `plugin_path` folder via FTP to the path in `HOSTINGER_FTP_TARGET_DIR`.
- If you supply an SSH key in `HOSTINGER_SSH_KEY`, the workflow will attempt to create a remote backup and set permissions via SSH.

Required GitHub Secrets (you said you already added these):
- `HOSTINGER_FTP_HOST` - Hostinger FTP hostname
- `HOSTINGER_FTP_PORT` - FTP port (optional)
- `HOSTINGER_FTP_USER` - FTP username
- `HOSTINGER_FTP_PASSWORD` - FTP password
- `HOSTINGER_FTP_TARGET_DIR` - Remote path to deploy to, e.g. `/home/username/public_html/wp-content/plugins/techforbs-components`
- `HOSTINGER_SSH_KEY` - (optional) private SSH key for backup/permission actions

How to run a dry-run
1. Go to Actions → Deploy WP Backend to Hostinger → Run workflow.
2. Set `dry_run` to `true` and `plugin_path` to `techforbs-components`.
3. Inspect logs — the remote directory will be listed.

How to run a real deploy
1. Ensure the secrets above are set.
2. Run the workflow with `dry_run=false`.

If you want the workflow file itself stored inside `techforbs-components/` for visibility, we can add a copy there as documentation, but GitHub will only execute the workflow file from `.github/workflows/` at the repo root.

If you'd like, I can now:
- Add a build step (npm / composer) before packaging, or
- Run a dry-run deployment for you (requires secrets to be set in the repo), or
- Add a second workflow that deploys to a staging path when pushing to a `staging` branch.

Which would you like next?