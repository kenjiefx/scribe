# scribe

Well, first of all, (let me educate you) **scribe** is _not_ a package/dependency manager.  
Instead, it’s a lightweight tool that pulls files directly from your private repositories.

## But... why?

Sometimes you don’t need a full package management workflow - no versions, no publishing, no installations.  
You just want specific files from a repository (who knows? 🤷‍♂️), exactly as they are, synced into your project.

scribe does exactly that: **fetch only what you need, when you need it**, with minimal setup and no extra package manager overhead.

#### Example: skeleton files

For example, teams may maintain “skeleton” or “boilerplate” files - common base structures for new services, modules, or components.  
Instead of copying them manually (and risking outdated versions), well, scribe can fetch them directly from a private repo.
Plus, it costs 💰 to host private npm/composer/etc.
