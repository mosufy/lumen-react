import React from 'react';
import Header from './Header';
import Footer from './Footer';

export default class App extends React.Component {
  render() {
    var path = this.props.children.props.route.path;
    var pageTemplate = 'public';

    if (path && path.substring(0, 9) == 'dashboard') {
      pageTemplate = 'dashboard';
    }

    return (
      <div className="container">
        <Header pageTemplate={pageTemplate}/>
        {this.props.children}
        <Footer/>
      </div>
    )
  }
}