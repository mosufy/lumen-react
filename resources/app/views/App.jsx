import React from 'react';
import Header from './../components/Header.jsx';
import Footer from './../components/Footer.jsx';

export default class App extends React.Component {
  render() {
    var path = this.props.children.props.route.path;
    var pageTemplate = 'public';

    if (path && path.substring(0, 2) == 'my') {
      pageTemplate = 'my';
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
