# Advanced Themer Framework Parser

## Enables you to manage your own SASS framework & automatically have the CSS Vars abailable in Advanced Themer Pickers, CSS Rules in Bricks Builder 

### The only requirement for the generated CSS is to comment above sets of CSS Variables to tell AT what category to put them in. Example below.
<pre><code>
/* @at-category: X Size */
:root {
  --x-size--xs: 0.5rem;
  --x-size--s: 1.2rem;
  --x-size--n: 1.5rem;
  --x-size--m: 2rem;
  --x-size--l: 3rem;
  --x-size--xl: 7rem;
  --x-size--2xl: 11rem;
  --x-size--3xl: 15rem;
  --x-size--4xl: 24rem;
}
</code></pre>

This would add the Variable in ATVariable Pickers under the category "X Size"
