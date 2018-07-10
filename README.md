# nppEvalCalc
Plugin for Pork2Sausage for Notepad++ - calculator solving selected equation which bases on PHP syntax with syntactic sugar, to allow non-coders to use it. While it uses simple eval(), it has some interesting features like *maximal* decimal precision, calculating multiple equations (one per line, nEC automagically uses new line which is used in current document) or returning original equation as a result. These features can be tuned or turned off by config. Optionally nEC can be put into toolbar.

# Examples
**Basic equation (with setting `'includeOriginalExpression' => true`)**<br>
Input: `5+5*3`<br>
Output: `5+5*3 = 20`<br>

**Count the area of circle with r=8 (`pi()` variable + usage of `^` as exponential + decimal precision)**<br>
Input: `pi()*(8^2)`<br>
Output: `31.41593`<br>

**Multiple equations (example of *maximal decimal precision* and thousands formatting)**<br>
Input:<br>
`(10^6)+(5/2)`<br>
`1/3`<br>
`1+1`<br><br>
Output:<br>
`1 000 002.5` (one floating point digit, as no more is needed)<br>
`0.33333` (reached maximal precision, which can be easily set)<br>
`2` (result expressed as integer number, as there's no floating point numbers)<br>

**Real world case (check which standard image proportion is closest to image size; with setting `'semicolonToDivision' => true` and `'includeOriginalExpression' => true`)**<br>
Input:<br>
`765:576` (image size)<br>
`3:2` (sample proportions)<br>
`4:3`<br>
`16:9`<br>
`16:10`<br><br>
Output:<br>
`765:576 = 1.32813`<br>
`3:2 = 1.5`<br>
`4:3 = 1.33333` [closest one!]<br>
`16:9 = 1.77778`<br>
`16:10 = 1.6`<br>

# Requirements
1. Notepad++ (https://notepad-plus-plus.org/download/)
2. Pork2Sausage plugin for N++ (downloadable via Plugin Manager)
3. PHP (branch 7.x, the rest is up to you; https://windows.php.net/download/)
4. [optional] Customize Toolbar plugin for N++ (downloadable via Plugin Manager)

# First steps
1. Download `evalCalc.php` and put it into some directory
2. Get `pork2Sausage.template.ini` and change following values:
* set path to PHP binary (directory+filename) in `progPath`
* set path to script (directory+filename) in `progCmd`
*change `workDir` to script directory (same as above, but without filename)
3. *Append* lines below to your `%APPDATA%\Notepad++\plugins\Config\pork2Sausage.ini`

# Custom button in toolbar
1. Download `toolbar_ico_eval_calc.bmp` to `%APPDATA%\Notepad++\plugins\Config\`
2. Append `Plugins,Pork to Sausage,EvalCalc,,toolbar_ico_eval_calc.bmp` line to `%APPDATA%\Notepad++\plugins\Config\CustomizeToolbar.btn`

# Script config
For now all possible config is inside `evalCalc.php` with proper documentation - you don't have to know PHP to change settings.