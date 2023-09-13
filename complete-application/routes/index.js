const express = require('express');
const passport = require('passport');
const router = express.Router();

function checkAuthenticated(req, res, next) {
  if (!req.isAuthenticated()) return res.redirect('/login');
  return next();
}

router.get('/', function (req, res, next) {
  if (req.isAuthenticated()) return res.redirect('/account');
  res.render('index', {});
});

router.get('/login', passport.authenticate('oauth2'));

router.get(
  '/auth/callback',
  passport.authenticate('oauth2', {
    successRedirect: '/account',
    failureRedirect: '/',
  })
);

router.get('/logout', function (req, res, next) {
  req.logOut(() => {
    res.redirect('/');
  });
});

router.get('/account', checkAuthenticated, function (req, res, next) {
  res.render('account', { email: req.user });
});

router.get('/change', checkAuthenticated, function (req, res, next) {
  const state = { error: false, hasChange: false, total: '', nickels: '', pennies: '', email: req.user};
  res.render('change', {state});
});

router.post('/change', checkAuthenticated, function (req, res, next) {
  const amount = req.body.amount;
  const state = { error: false, hasChange: true, total: '', nickels: '', pennies: ''};
  const total = Math.trunc(parseFloat(amount)*100)/100;
  state.total = isNaN(total) ? '' : total.toFixed(2);
  const nickels = Math.floor(total / 0.05);
  state.nickels = nickels.toLocaleString();
  const pennies = ((total - (0.05 * nickels)) / 0.01);
  state.pennies = Math.ceil((Math.trunc(pennies*100)/100)).toLocaleString();
  state.error = ! /^(\d+(\.\d*)?|\.\d+)$/.test(amount);
  state.email = req.user;
  res.render('change', {state});
});

module.exports = router;
