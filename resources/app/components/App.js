import React from 'react';
import Header from './Header';
import Footer from './Footer';

export default class App extends React.Component {
  render() {
    return (
      <div className="container">
        <Header pageTemplate={this.props.pageTemplate} logoutLink={this.props.logoutLink}/>
        {this.props.children}
        <Footer/>
      </div>
    )
  }
}