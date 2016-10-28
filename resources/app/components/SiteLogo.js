import React from 'react';

export default class SiteLogo extends React.Component {
  render() {
    var logoTitle;

    if (this.props.pageTemplate == 'public') {
      logoTitle = 'My TODOs';
    } else {
      if (this.props.user.name == undefined) {
        logoTitle = 'Welcome, User';
      } else {
        logoTitle = 'Welcome, ' + this.props.user.name;
      }
    }

    return (
      <h3 className="text-muted">{logoTitle}</h3>
    );
  }
}