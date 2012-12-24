package org.fastre.cigogne.client;

import com.google.gwt.core.client.EntryPoint;
import com.google.gwt.event.shared.HandlerManager;
import com.google.gwt.user.client.Window;
import com.google.gwt.user.client.ui.RootPanel;

public class CigogneEntryPoint implements EntryPoint {

	public void onModuleLoad() {
		HandlerManager eventBus = new HandlerManager(null);
		AppController appController = new AppController(eventBus);
		appController.go(RootPanel.get("panel"));
		
		
	}

}
