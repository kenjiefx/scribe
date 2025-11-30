# scribe

Well, first of all, (let me educate you), **scribe** is _not_ a package/dependency manager.

Instead, it’s a lightweight tool that pulls files directly from your private repositories.

## But... why?

Sometimes you don’t need a full package management workflow - no versions, no publishing, no installations.

You just want specific files from a repository (who knows? 🤷‍♂️), exactly as they are, synced into your project.

Scribe does exactly that: **fetch only what you need, when you need it**, with minimal setup and no extra package manager overhead.

#### Maybe a use-case: skeleton files

For example, teams may maintain “skeleton” or “boilerplate” files - common base structures for new services, modules, or components.

Instead of copying them manually (and risking outdated versions), well, scribe can fetch them directly from a private repo.

Plus, it costs 💰 to host private npm/composer/etc.

## Installation

You can install Scribe using composer, like so:

```bash
composer require kenjiefx/scribe
```

## Setup

In your project's `/bin` directory, you will want to add this script:

```php
#!/usr/bin/php
<?php
use Kenjiefx\Scribe\App;

define('ROOT', dirname(__DIR__));
require 'vendor/autoload.php';

$App = new App();
$App->run();
```

To declare your sources, you will want to add a file named `scribe.json` in your `<root>` directory.

```json
{
  "sources": {
    "some_nickname": {
      "platform": "github",
      "owner": "someowner",
      "repository": "somerepo",
      "release": "v1.0.0",
      "pulls": {
        "./tsconfig.json": "./tsconfig.json",
        "./src/app/upload": "./scripts/uploads"
      }
    }
  }
}
```

Lastly, you will want to add GitHub credentials to your `.env` file, like so

```env
GITHUB_USERNAME=yourusername
GITHUB_TOKEN=youraccesstoken
```

You can learn more about GitHub's personal access token in this link: https://docs.github.com/en/authentication/keeping-your-account-and-data-secure/managing-your-personal-access-tokens

### Found An Issue?

Well, create an issue.

## Product Roadmap

✅ Pull from GitHub repo releases

⬛ Pull from a specific GitHub branch

⬛ Pull from S3 bucket

⬛ Pull a specific source using the nickname
