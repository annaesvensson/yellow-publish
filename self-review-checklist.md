# Self-review checklist

You should always review your own extension first. Please make sure:

- [ ] repository has the topic `datenstrom-yellow`, [see documentation](https://docs.github.com/en/repositories/managing-your-repositorys-settings-and-features/customizing-your-repository/classifying-your-repository-with-topics)
- [ ] repository has the license `GPL version 2`, [see license file](https://github.com/datenstrom/yellow/blob/main/LICENSE.md)
- [ ] check that the extension works with a brand new installation
- [ ] check for consistency, apply the same patterns and standards at all times
- [ ] check for code security and adherence to our coding standard
- [ ] check for spelling errors and adherence to our documentation standard
- [ ] do not have features just in case someone needs them later
- [ ] do not have code comments inside methods and functions, see note A
- [ ] do not have more than one extension per repository, see note B
- [ ] do not have failing tests in a pull request

<a id="note-a"></a>Note A: Our coding standard uses code comments mainly for:

- file header and legal stuff, as little as necessary
- class methods and functions, one comment line before
- instance variables, one comment at the end of the line
- there are exceptions for TODOs, for example things that need fixing in a later release

<a id="note-b"></a>Note B: Our documentation standard recommends one extension per repository:

- easier to explore all extensions at https://github.com/topics/datenstrom-yellow
- easier to know which extensions you have worked on recently, GitHub profile lists them
- easier to hand over extensions to another developer/designer, GitHub repository has redirect
- there are exceptions for special cases, for example for translations and the installer
 
Do you have questions? [Get help](https://datenstrom.se/yellow/help/).
