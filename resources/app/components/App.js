import React from 'react';
import Header from './Header';
import Footer from './Footer';

const App = (props) => {
  return (
    <div className="container">
      <Header pageTemplate={props.pageTemplate} logoutLink={props.logoutLink} user={props.user}/>
      {props.children}
      <Footer/>
    </div>
  )
};

export default App;