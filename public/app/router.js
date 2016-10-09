/**
 * ReactJS app router
 *
 * @date 9/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

ReactDOM.render(
  <Router history={browserHistory}>
    <Route path="/" component={App}>
      <IndexRoute component={Home}/>
      <Route path="stuff" component={Stuff}>
        <Route path="inner" component={InnerStuff}/>
      </Route>
      <Route path="contact" component={Contact}/>
    </Route>
  </Router>,
  document.getElementById('container')
);