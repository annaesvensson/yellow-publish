# Self-review checklist

You should always review your own extension first. Please make sure:

- [ ] repository has the topic `datenstrom-yellow`, [see documentation](https://docs.github.com/en/repositories/managing-your-repositorys-settings-and-features/customizing-your-repository/classifying-your-repository-with-topics)
- [ ] repository has the license `GPL version 2`, [see license file](https://github.com/datenstrom/yellow/blob/main/LICENSE.md)
- [ ] check that the extension works with a brand new installation
- [ ] check for consistency, apply the same patterns and standards at all times
- [ ] check for code security and adherence to our coding standards
- [ ] check for spelling errors and adherence to our documentation standards
- [ ] do not have features just in case someone needs them later
- [ ] do not have code comments inside methods and functions, communicate exceptions
- [ ] do not have more than one extension per repository, communicate exceptions
- [ ] If there are failing tests in a pull request, fix them until they're passing

Our coding standard uses few code comments, mainly for:

- file header and legal stuff, as little as necessary
- class methods and functions, one comment line before
- class instance variables, one comment at the end of the line
- TODOs, for example things that need fixing in a later release

Our documentation standard uses one extension per repository, mainly to:

- explore all extensions at https://github.com/topics/datenstrom-yellow
- mark which extensions are experimental, for example with the topic `experimental`
- know which extensions someone has worked on recently, GitHub profiles list them
- hand over extensions between developers/designers, GitHub has an automatic redirect

Do you have questions? [Get help](https://datenstrom.se/yellow/help/).
